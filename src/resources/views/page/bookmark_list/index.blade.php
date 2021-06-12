@extends('base.default')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/page/bookmark_list.css') }}">
@endsection

@php
    /**
    * @var string $h1
    * @var array|App\Models\Bookmark[]|Illuminate\Contracts\Pagination\LengthAwarePaginator $bookmarks
    * @var array|App\Models\BookmarkCategory[] $top_categories
    * @var array|App\Models\User[] $top_users
    */
@endphp

@section('content')
    <div class="main">
        <div class="heading-area">
            <h1 class="heading-main">
                {{ $h1 }}
            </h1>
        </div>
        <div class="bookmark-area">
            <div class="bookmark-list center">
                @foreach($bookmarks as $bookmark)
                    <div class="bookmark-card">
                        <figure class="bookmark-image">
                            <img src="{{ $bookmark->page_thumbnail_url }}" alt="{{ $bookmark->page_title }}"
                                 class="bookmark-image__img">
                        </figure>
                        <div class="bookmark-body-area">
                            <div class="bookmark-tag">
                                <span class="bookmark-tag__item">
                                    {{ $bookmark->category->display_name  }}
                                </span>
                            </div>
                            <div class="bookmark-title">
                                {{ $bookmark->page_title }}
                            </div>
                            <p class="bookmark-desc">
                                {{ $bookmark->shorten_description }}
                            </p>
                            <div class="bookmark-user">
                                {{ $bookmark->user->name  }}さんのコメント
                            </div>
                            <p class="bookmark-comment">
                                {{ $bookmark->comment  }}
                            </p>
                        </div>
                    </div>
                @endforeach
                <div class="paginate">
                    {{ $bookmarks->links() }}
                </div>
            </div>
            <div class="right-bar">
                <div class="section">
                    <h2>
                        人気のカテゴリー
                    </h2>
                    <div class="category-list list-group">
                        @foreach($top_categories as $category)
                            <a href="/bookmarks/category/{{ $category->id }}" class="list-group-item">
                                <div class="title">
                                    {{ $category->display_name }}
                                </div>
                                <div class="small">
                                <span class="category-meta">
                                    投稿されたブックマーク：{{ $category->bookmarks_count }}件
                                </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="section">
                    <h2>
                        投稿数の多いユーザー
                    </h2>
                    <div class="category-list list-group">
                        @foreach($top_users as $user)
                            <div class="list-group-item">
                                <div class="title">
                                    {{ $user->name }}さん
                                </div>
                                <div class="small">
                                <span class="category-meta">
                                    投稿されたブックマーク：{{ $user->bookmarks_count }}件
                                </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection