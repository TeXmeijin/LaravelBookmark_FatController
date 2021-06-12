<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('投稿者のID');
            $table->unsignedBigInteger('category_id')->nullable()->comment('カテゴリのID');
            $table->string('url', 255)->comment('ブックマークしたURL');
            $table->text('comment')->comment('ブックマークした内容に対するコメント。将来的な拡張も見据えて文字数は余裕をもたせる');
            $table->string('page_title', 100)->default('')->comment('ブックマークしたページのタイトル');
            $table->string('page_thumbnail_url', 255)->default('')->comment('ブックマークしたページのサムネイル（OGP画像）');
            $table->string('page_description', 300)->default('')->comment('ブックマークしたページのDescription');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // ユーザーが退会したとき等で物理削除したら関連ブックマークも消す
            $table->foreign('category_id')->references('id')->on('bookmark_categories')->onDelete('set null'); // カテゴリを運営の都合等で消してもブックマークは残す

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}
