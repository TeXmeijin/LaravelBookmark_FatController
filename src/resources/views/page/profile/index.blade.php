@extends('base.default')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/page/profile.css') }}">
@endsection

@php
    /**
    * @var string $h1
    * @var array|App\Models\Bookmark[]|Illuminate\Contracts\Pagination\LengthAwarePaginator $bookmarks
    * @var array|App\Models\User $user
    */
@endphp

@section('content')
    <div class="main">
        <div class="heading-area">
            <h1 class="heading-main">
                {{ $user->name }}さんのプロフィール
            </h1>
        </div>
        @if(count($errors))
            <ul class="error-messages">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @foreach($bookmarks as $bookmark)
            @component('components.bookmark_card', [ 'bookmark' => $bookmark, 'enable_edit_action' => true ])
            @endcomponent
        @endforeach
    </div>
@endsection