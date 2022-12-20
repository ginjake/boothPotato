<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwitterLoginController extends Controller
{
    public function redirectToProvider() {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback() {
        try {
            $twitterUser = Socialite::with('twitter')->user();
        }catch (Exception $e) {
            return redirect('login/twitter');
        }

        $user = User::updateOrCreate(
            ['twitterId' => $twitterUser->getId()],
            [
                'nickName' => $twitterUser->getNickname(),
                'name' => $twitterUser->getName(),
                'avatar' => $twitterUser->getAvatar(),
            ]
        );

        Auth::login($user);
        return redirect()->to('/home');
    }
}
