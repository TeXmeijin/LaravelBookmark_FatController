<?php

namespace Tests\Feature\Bookmarks;

use App\Bookmark\UseCase\ShowBookmarkListPageUseCase;
use Artesaos\SEOTools\Facades\SEOTools;
use Tests\TestCase;

class ShowBookmarkListPageUseCaseTest extends TestCase
{
    private ShowBookmarkListPageUseCase $useCase;

    /**
     * setUpメソッドは、各テストケース(testXXXという名前のメソッド)が
     * 実行される前に毎回実行されます。
     * なので、テストデータのセットアップや利用するクラスの初期化を行うのに最適です
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->useCase = new ShowBookmarkListPageUseCase();
    }

    public function testResponseIsCorrect()
    {
        /**
         * SEOについて
         * ・<title>タグの中身が正しく設定されていること
         * ・<meta description>の中身が正しく設定されていること
         */
        SEOTools::shouldReceive('setTitle')->withArgs(['ブックマーク一覧'])->once();
        SEOTools::shouldReceive('setDescription')->withArgs(['技術分野に特化したブックマーク一覧です。みんなが投稿した技術分野のブックマークが投稿順に並んでいます。HTML、CSS、JavaScript、Rust、Goなど、気になる分野のブックマークに絞って調べることもできます'])->once();

        $response = $this->useCase->handle();

        /**
         * テストすること
         * ・ブックマーク一覧について：10件取得できていること、最新順で10件になっていること
         * ・トップカテゴリーについて：10件取得できていること、内容が投稿数順になっていること
         * ・トップユーザーについて：10人取得できていること、内容が投稿数順になっていること
         */
        self::assertCount(10, $response['bookmarks']);

        // 以下が追加した内容です！
        self::assertCount(10, $response['top_categories']);
        self::assertCount(10, $response['top_users']);

        // bookmarksの中身を軽くチェック。IDが大きい順に格納されていればOK
        for ($i = 100; $i > 90; $i--) {
            self::assertSame($i, $response['bookmarks'][100 - $i]->id);
        }

        // top_categoriesの中身を軽くチェック。IDが小さい順に格納されていればOK
        for ($i = 1; $i < 10; $i++) {
            self::assertSame($i, $response['top_categories'][$i - 1]->id);
        }

        // top_usersの中身を軽くチェック。IDが小さい順に格納されていればOK
        for ($i = 1; $i < 10; $i++) {
            self::assertSame($i, $response['top_users'][$i - 1]->id);
        }
    }
}