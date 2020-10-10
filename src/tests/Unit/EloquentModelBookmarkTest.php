<?php

namespace Tests\Unit;

use App\Models\Bookmark;
use App\Models\BookmarkCategory;
use App\Models\User;
use Tests\TestCase;

class EloquentModelBookmarkTest extends TestCase
{
    public function testBookmarkFactoryCorrect()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var BookmarkCategory $category */
        $category = factory(BookmarkCategory::class)->create();
        factory(Bookmark::class)->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseHas((new Bookmark())->getTable(), [
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);
    }
}
