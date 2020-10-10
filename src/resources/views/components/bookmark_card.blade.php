@php
    /**
    * @var App\Models\Bookmark $bookmark
    * @var boolean? $enable_edit_action
    */
@endphp

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
    @isset($enable_edit_action)
        <div class="bookmark-action-area">
            <a class="bookmark-action-area__item" href="/bookmark-edit/{{ $bookmark->id }}">編集する</a>
            <a class="bookmark-action-area__item" href="#" onclick="event.preventDefault();document.getElementById('delete-form-{{ $bookmark->id }}').submit();">削除する</a>
            <form class="is-hide" id="delete-form-{{ $bookmark->id }}" action="/bookmarks/{{ $bookmark->id }}" method="POST">
                <input type="hidden" name="_method" value="DELETE">
                @csrf
            </form>
        </div>
    @endisset
</div>