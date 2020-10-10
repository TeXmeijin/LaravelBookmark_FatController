<header class="header">
    <a href="/" class="logo">
        <span class="logo__text">
            Tech Marker
        </span>
    </a>
    <div class="auth-area">
        @auth()
            <a href="/bookmark-create" class="auth-btn auth-btn--text">
                ブックマーク作成
            </a>
            <a href="/user/profile" class="auth-btn auth-btn--text">
                プロフィール
            </a>
            <a class="auth-btn auth-btn--text" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                ログアウト
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="/login" class="auth-btn auth-btn--text">
                ログイン
            </a>
            <a href="/register" class="auth-btn">
                新規登録
            </a>
        @endisset
    </div>
</header>