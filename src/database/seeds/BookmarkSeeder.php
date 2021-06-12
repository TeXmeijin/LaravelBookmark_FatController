<?php


use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class BookmarkSeeder extends Seeder
{
    public function __invoke()
    {
        /**
         * シーダーの内容
         * ・投稿者となるユーザーアカウントを30人作る
         * ・ブックマークのカテゴリを30個作る
         * ・ブックマークを100件作る
         *
         * ・ユーザーごとに、作成するブックマークは1,2,5,5,10,10,17,20,30,残りは0
         * ・ブックマークのカテゴリは多い順に13,12,11,10,9,9,8,...,1,残りは0
         */

        $user_ids = [];
        $factory_ids = [];

        for ($i = 0; $i < 30; $i++) {
            $user_ids[] = factory(User::class)->create()->id;
        }
        $first_user_id = User::query()->first()->id;

        $tech_categories = $this->getTestCategoryNames();
        for ($i = 0; $i < 30; $i++) {
            $category = $tech_categories[$i];

            $factory_ids[] = factory(BookmarkCategory::class)->create([
                'display_name' => $category ?? 'テスト用カテゴリ',
                'slug' => $category ?? 'test-category-' . Str::random(6),
            ])->id;
        }

        $first_category_id = BookmarkCategory::query()->first()->id;

        $user_bookmark_counts = [30, 50, 67, 77, 87, 92, 97, 99, 100];
        $category_bookmark_counts = [13, 25, 36, 46, 55, 64, 72, 79, 85, 90, 94, 97, 99, 100];

        for ($i = 0; $i < 100; $i++) {
            $user_id = null;
            $category_id = null;
            foreach ($user_bookmark_counts as $index => $count) {
                if ($count > $i) {
                    $user_id = $index + $first_user_id;
                    break;
                }
            }
            foreach ($category_bookmark_counts as $index => $count) {
                if ($count > $i) {
                    $category_id = $index + $first_category_id;
                    break;
                }
            }

            if ($user_id === null || $category_id === null) {
                continue;
            }

            factory(Bookmark::class)->create([
                'user_id' => $user_id,
                'category_id' => $category_id,
                'page_title' => "{$tech_categories[$category_id - 1]}の記事タイトル",
                'created_at' => now()->addDays($i)
            ]);
        }
    }

    /**
     * 技術カテゴリ名の配列
     * @see https://github.com/kamranahmedse/developer-roadmap
     *
     * @return string[]
     */
    private function getTestCategoryNames(): array {
        return [
            'HTML',
            'CSS',
            'JavaScript',
            'Rust',
            'Go',
            'Java',
            'C#',
            'PHP',
            'TypeScript',
            'Python',
            'Ruby',
            'PostgreSQL',
            'MySQL',
            'MongoDB',
            'DynamoDB',
            'gRPC',
            'HTTP/DNS/TCP',
            'Authentication',
            'Security',
            'Redis',
            'Testing',
            'CI/CD',
            'Design Patterns',
            'Microservices',
            'Elasticsearch',
            'Test Driven Development',
            'Docker',
            'GraphQL',
            'Nginx',
            'WebSockets',
        ];
    }
}