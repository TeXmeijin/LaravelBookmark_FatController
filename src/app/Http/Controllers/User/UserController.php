<?php


namespace App\Http\Controllers\User;


use App\Models\Bookmark;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Auth;

class UserController extends \App\Http\Controllers\Controller
{
    /**
     * プロフィールの表示
     * プロフィールといいつつ、ここでは簡略のため自身のブックマーク一覧のみ表示する
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function showProfile()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        /** @var User $user */
        $user = Auth::user();

        SEOTools::setTitle("{$user->name}さんのプロフィール");

        $bookmarks = Bookmark::query()->where('user_id', '=', $user->id)->get();

        return view('page.profile.index', [
            'user' => $user,
            'bookmarks' => $bookmarks
        ]);
    }
}