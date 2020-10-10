<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bookmark[] $bookmarks
 * @property-read int|null $bookmarks_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bookmark
 *
 * @property int $id
 * @property int $user_id 投稿者のID
 * @property int|null $category_id カテゴリのID
 * @property string $url ブックマークしたURL
 * @property string $comment ブックマークした内容に対するコメント。将来的な拡張も見据えて文字数は余裕をもたせる
 * @property string $page_title ブックマークしたページのタイトル
 * @property string $page_thumbnail_url ブックマークしたページのサムネイル（OGP画像）
 * @property string $page_description ブックマークしたページのDescription
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BookmarkCategory|null $category
 * @property-read mixed $can_not_delete_or_edit
 * @property-read mixed $shorten_description
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark wherePageDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark wherePageThumbnailUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark wherePageTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bookmark whereUserId($value)
 */
	class Bookmark extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookmarkCategory
 *
 * @property int $id
 * @property string $display_name カテゴリの表示名（日本語）
 * @property string $slug カテゴリ一覧等でURLに表示するときの名前（英数字）
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bookmark[] $bookmarks
 * @property-read int|null $bookmarks_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookmarkCategory whereUpdatedAt($value)
 */
	class BookmarkCategory extends \Eloquent {}
}

