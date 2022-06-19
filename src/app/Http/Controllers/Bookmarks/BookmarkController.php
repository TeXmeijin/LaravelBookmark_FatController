<?php


namespace App\Http\Controllers\Bookmarks;

use App\Bookmark\UseCase\ShowBookmarkListPageUseCase;
use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Dusterio\LinkPreview\Client;
use Dusterio\LinkPreview\Exceptions\UnknownParserException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    /**
     * ブックマーク一覧画面
     *
     * SEO
     * title, description
     * titleは固定、descriptionは人気のカテゴリTOP5を含める
     *
     * ソート
     * ・投稿順で最新順に表示
     *
     * ページ内に表示される内容
     * ・ブックマーク※ページごとに10件
     * ・最も投稿件数の多いカテゴリ※トップ10件
     * ・最も投稿数の多いユーザー※トップ10件
     *
     * @return Application|Factory|View
     */
    public function list(Request $request, ShowBookmarkListPageUseCase $useCase)
    {
        return view('page.bookmark_list.index', [
            'h1' => 'ブックマーク一覧',
        ] + $useCase->handle());
    }

    /**
     * カテゴリ別ブックマーク一覧
     *
     * カテゴリが数字で無かった場合404
     * カテゴリが存在しないIDが指定された場合404
     *
     * title, descriptionにはカテゴリ名とカテゴリのブックマーク投稿数を含める
     *
     * 表示する内容は普通の一覧と同様
     * しかし、カテゴリに関しては現在のページのカテゴリを除いて表示する
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function listCategory(Request $request)
    {
        $category_id = $request->category_id;
        if (!is_numeric($category_id)) {
            abort(404);
        }

        $category = BookmarkCategory::query()->findOrFail($category_id);

        SEOTools::setTitle("{$category->display_name}のブックマーク一覧");
        SEOTools::setDescription("{$category->display_name}に特化したブックマーク一覧です。みんなが投稿した{$category->display_name}のブックマークが投稿順に並んでいます。全部で{$category->bookmarks->count()}件のブックマークが投稿されています");

        $bookmarks = Bookmark::query()->with(['category', 'user'])->where('category_id', '=', $category_id)->latest('id')->paginate(10);

        // 自身のページのカテゴリを表示しても意味がないのでそれ以外のカテゴリで多い順に表示する
        $top_categories = BookmarkCategory::query()->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->orderBy('id')->where('id', '<>', $category_id)->take(10)->get();

        $top_users = User::query()->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->take(10)->get();

        return view('page.bookmark_list.index', [
            'h1' => "{$category->display_name}のブックマーク一覧",
            'bookmarks' => $bookmarks,
            'top_categories' => $top_categories,
            'top_users' => $top_users
        ]);
    }

    /**
     * ブックマーク作成フォームの表示
     * @return Application|Factory|View
     */
    public function showCreateForm()
    {
        if (Auth::id() === null) {
            return redirect('/login');
        }

        SEOTools::setTitle('ブックマーク作成');

        $master_categories = BookmarkCategory::query()->oldest('id')->get();

        return view('page.bookmark_create.index', [
            'master_categories' => $master_categories,
        ]);
    }

    /**
     * ブックマーク作成処理
     *
     * 未ログインの場合、処理を続行するわけにはいかないのでログインページへリダイレクト
     *
     * 投稿内容のURL、コメント、カテゴリーは不正な値が来ないようにバリデーション
     *
     * ブックマークするページのtitle, description, サムネイル画像を専用のライブラリを使って取得し、
     * 一緒にデータベースに保存する※ユーザーに入力してもらうのは手間なので
     * URLが存在しないなどの理由で失敗したらバリデーションエラー扱いにする
     *
     * @param Request $request
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        if (Auth::guest()) {
            // @note ここの処理はユーザープロフィールでも使われている
            return redirect('/login');
        }

        Validator::make($request->all(), [
            'url' => 'required|string|url',
            'comment' => 'required|string|min:10|max:1000',
            'category' => 'required|integer|exists:bookmark_categories,id',
        ])->validate();

        // 下記のサービスでも同様のことが実現できる
        // @see https://www.linkpreview.net/
        $previewClient = new Client($request->url);
        try {
            $preview = $previewClient->getPreview('general')->toArray();

            $model = new Bookmark();
            $model->url = $request->url;
            $model->category_id = $request->category;
            $model->user_id = Auth::id();
            $model->comment = $request->comment;
            $model->page_title = $preview['title'];
            $model->page_description = $preview['description'];
            $model->page_thumbnail_url = $preview['cover'];
            $model->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw ValidationException::withMessages([
                'url' => 'URLが存在しない等の理由で読み込めませんでした。変更して再度投稿してください'
            ]);
        }

        // 暫定的に成功時は一覧ページへ
        return redirect('/bookmarks', 302);
    }

    /**
     * 編集画面の表示
     * 未ログインであればログインページへ
     * 存在しないブックマークの編集画面なら表示しない
     * 本人のブックマークでなければ403で返す
     *
     * @param Request $request
     * @param int $id
     * @return Application|Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function showEditForm(Request $request, int $id)
    {
        if (Auth::guest()) {
            // @note ここの処理はユーザープロフィールでも使われている
            return redirect('/login');
        }

        SEOTools::setTitle('ブックマーク編集');

        $bookmark = Bookmark::query()->findOrFail($id);
        if ($bookmark->user_id !== Auth::id()) {
            abort(403);
        }

        $master_categories = BookmarkCategory::query()->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->orderBy('id')->take(10)->get();

        return view('page.bookmark_edit.index', [
            'user' => Auth::user(),
            'bookmark' => $bookmark,
            'master_categories' => $master_categories,
        ]);
    }

    /**
     * ブックマーク更新
     * コメントとカテゴリのバリデーションは作成時のそれと合わせる
     * 本人以外は編集できない
     * ブックマーク後24時間経過したものは編集できない仕様
     *
     * @param Request $request
     * @param int $id
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {
        if (Auth::guest()) {
            // @note ここの処理はユーザープロフィールでも使われている
            return redirect('/login');
        }

        Validator::make($request->all(), [
            'comment' => 'required|string|min:10|max:1000',
            'category' => 'required|integer|exists:bookmark_categories,id',
        ])->validate();

        $model = Bookmark::query()->findOrFail($id);

        if ($model->can_not_delete_or_edit) {
            throw ValidationException::withMessages([
                'can_edit' => 'ブックマーク後24時間経過したものは編集できません'
            ]);
        }

        if ($model->user_id !== Auth::id()) {
            abort(403);
        }

        $model->category_id = $request->category;
        $model->comment = $request->comment;
        $model->save();

        // 成功時は一覧ページへ
        return redirect('/bookmarks', 302);
    }

    /**
     * ブックマーク削除
     * 公開後24時間経過したものは削除できない
     * 本人以外のブックマークは削除できない
     *
     * @param int $id
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws ValidationException
     */
    public function delete(int $id)
    {
        if (Auth::guest()) {
            // @note ここの処理はユーザープロフィールでも使われている
            return redirect('/login');
        }

        $model = Bookmark::query()->findOrFail($id);

        if ($model->can_not_delete_or_edit) {
            throw ValidationException::withMessages([
                'can_delete' => 'ブックマーク後24時間経過したものは削除できません'
            ]);
        }

        if ($model->user_id !== Auth::id()) {
            abort(403);
        }

        $model->delete();

        // 暫定的に成功時はプロフィールページへ
        return redirect('/user/profile', 302);
    }
}
