<?php

namespace App\Bookmark\UseCase;

use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools;

final class ShowBookmarkListPageUseCase
{
    /**
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
     * @return array
     */
    public function handle(): array
    {
        /**
         * SEOに必要なtitleタグなどをファサードから設定できるライブラリ
         * @see https://github.com/artesaos/seotools
         */
        SEOTools::setTitle('ブックマーク一覧');

        $bookmarks = Bookmark::query()->with(['category', 'user'])->latest('id')->paginate(10);

        $top_categories = BookmarkCategory::query()->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->orderBy('id')->take(10)->get();

        // Descriptionの中に人気のカテゴリTOP5を含めるという要件
        SEOTools::setDescription("技術分野に特化したブックマーク一覧です。みんなが投稿した技術分野のブックマークが投稿順に並んでいます。{$top_categories->pluck('display_name')->slice(0, 5)->join('、')}など、気になる分野のブックマークに絞って調べることもできます");

        $top_users = User::query()->withCount('bookmarks')->orderBy('bookmarks_count', 'desc')->orderBy('id')->take(10)->get();

        return [
            'bookmarks' => $bookmarks,
            'top_categories' => $top_categories,
            'top_users' => $top_users
        ];
    }
}