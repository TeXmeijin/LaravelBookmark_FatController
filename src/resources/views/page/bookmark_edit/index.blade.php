@extends('base.default')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/page/bookmark_create.css') }}">
@endsection

@php
    /**
    * @var array|App\Models\BookmarkCategory[] $master_categories
    * @var App\Models\Bookmark $bookmark
    */
@endphp

@section('content')
    <div class="main">
        <div class="heading-area">
            <h1 class="heading-main">
                ブックマーク編集
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
        <form action="/bookmarks/{{ $bookmark->id }}" method="post">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-item">
                <textarea name="comment" id="comment" cols="30" rows="10" placeholder="ブックマークコメント">{{ $bookmark->comment }}</textarea>
            </div>
            <div class="form-item">
                <div class="select-container">
                    <select name="category" id="category">
                        @foreach($master_categories as $category)
                            <option value="{{ $category->id }}" {{ $bookmark->category_id === $category->id ? 'selected' : '' }}>{{ $category->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-item form-item--submit">
                <button class="submit" type="submit">
                    保存する
                </button>
            </div>
        </form>
    </div>
@endsection