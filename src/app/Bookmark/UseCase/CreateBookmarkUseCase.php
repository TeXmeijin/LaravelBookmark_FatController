<?php

namespace App\Bookmark\UseCase;

use App\Models\Bookmark;
use Dusterio\LinkPreview\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

final class CreateBookmarkUseCase
{
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
     * @param string $url
     * @param int $category
     * @param string $comment
     * @throws ValidationException
     */
    public function handle(string $url, int $category, string $comment)
    {
        // 下記のサービスでも同様のことが実現できる
        // @see https://www.linkpreview.net/
        $previewClient = new Client($url);
        try {
            $preview = $previewClient->getPreview('general')->toArray();

            $model = new Bookmark();
            $model->url = $url;
            $model->category_id = $category;
            $model->user_id = Auth::id();
            $model->comment = $comment;
            $model->page_title = $preview['title'];
            $model->page_description = $preview['description'];
            $model->page_thumbnail_url = $preview['cover'];
            $model->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw ValidationException::withMessages([
                'url' => 'URLが存在しない等の理由で読み込めませんでした。変更して再度投稿してください'
            ]);
        }
    }
}
