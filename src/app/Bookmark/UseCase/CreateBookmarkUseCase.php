<?php

namespace App\Bookmark\UseCase;

use App\Models\Bookmark;
use Dusterio\LinkPreview\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Lib\LinkPreview\LinkPreviewInterface;




final class CreateBookmarkUseCase
{

    private LinkPreviewInterface $linkPreview;
 
    public function __construct(LinkPreviewInterface $linkPreview)
    {
        $this->linkPreview = $linkPreview;
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
            $preview = $this->linkPreview->get($url);


            $model = new Bookmark();
            $model->url = $url;
            $model->category_id = $category;
            $model->user_id = Auth::id();
            $model->comment = $comment;
            $model->page_title = $preview->title;
            $model->page_description = $preview->description;
            $model->page_thumbnail_url = $preview->cover;
            $model->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw ValidationException::withMessages([
                'url' => 'URLが存在しない等の理由で読み込めませんでした。変更して再度投稿してください'
            ]);
        }
    }

    public function testWhenFetchMetaFailed()
    {
        $url = 'https://notfound.example.com/';
        $category = BookmarkCategory::query()->first()->id;
        $comment = 'テスト用のコメント';

        // これまでと違ってMockeryというライブラリでモックを用意する
        $mock = \Mockery::mock(LinkPreviewInterface::class);

        // 作ったモックがgetメソッドを実行したら必ず例外を投げるように仕込む
        $mock->shouldReceive('get')
            ->withArgs([$url])
            ->andThrow(new \Exception('URLからメタ情報の取得に失敗'))
            ->once();

        // サービスコンテナに$mockを使うように命令する
        $this->app->instance(
            LinkPreviewInterface::class,
            $mock
        );

        // 例外が投げられることのテストは以下のように書く
        $this->expectException(ValidationException::class);
        $this->expectExceptionObject(ValidationException::withMessages([
            'url' => 'URLが存在しない等の理由で読み込めませんでした。変更して再度投稿してください'
        ]));

        // 仕込みが終わったので実際の処理を実行
        $this->useCase = $this->app->make(CreateBookmarkUseCase::class);
        $this->useCase->handle($url, $category, $comment);
    }
}