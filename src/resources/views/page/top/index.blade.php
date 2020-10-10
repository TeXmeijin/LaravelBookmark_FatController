@extends('base.default')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/page/top.css') }}">
@endsection

@section('content')
    <main class="main">
        <div class="catch-area">
            <h1 class="message">
                Web技術に特化した <br>
                記事ブックマークサイト
            </h1>
            <h2 class="categories">
                PHP, Laravel, Ruby, Rails, MySQL, JavaScript, Go, Rust, React...
            </h2>
            <div class="navigation">
                <a href="/register" class="navigation-button">
                    登録してブックマークする
                </a>
                <a href="/bookmarks" class="navigation-button outline">
                    みんなのブックマークを見る
                </a>
            </div>
        </div>
    </main>
@endsection
