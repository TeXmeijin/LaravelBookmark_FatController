@extends('base.default')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/page/bookmark_create.css') }}">
@endsection

@php
    /**
    * @var array|App\Models\BookmarkCategory[] $master_categories
    */
@endphp

@section('content')
    <div class="main">
        <div class="heading-area">
            <h1 class="heading-main">
                ブックマーク作成
            </h1>
        </div>
        @if(count($errors))
            <ul class="error-messages">
                {{-- ここは手抜きです、本当は入力エラー時はフラッシュから入力フォームに前の値を入れるなどしないといけない --}}
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="/bookmarks" method="post">
            @csrf
            <div class="form-item">
                <input name="url" type="text" id="url" placeholder="ブックマークする記事のURL">
            </div>
            <div class="form-item">
                <textarea name="comment" id="comment" cols="30" rows="5" placeholder="ブックマークコメント"></textarea>
            </div>
            <div class="form-item">
                <div class="select-container">
                    <select name="category" id="category">
                        <option value="">技術カテゴリを選択</option>
                        @foreach($master_categories as $category)
                            <option value="{{ $category->id }}">{{ $category->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-item form-item--submit">
                <button class="submit" type="submit">
                    作成する
                </button>
            </div>
        </form>
    </div>
@endsection