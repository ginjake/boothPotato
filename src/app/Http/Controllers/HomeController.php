<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gift;
use App\Constants\SortConstants;
use Carbon\Carbon;
use App\Http\Services\BoothContentCacheService;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $twitterId = $request->get('id');
        if ($twitterId == 1) {
            $twitterId = config('value.ginjakeTwitterId');
        }
        if (empty($twitterId)) {
            if (!empty(Auth::user())) {
                $twitterId = Auth::user()->twitterId;
            } else {
                $twitterId = config('value.ginjakeTwitterId');
            }
        }

        $user = User::where('twitterId', $twitterId)->first();
        if (isset($user->gifts)) {
            foreach ($user->gifts as $gift) {
                $boothContentCacheService = new BoothContentCacheService();
                $user->giftCache = $boothContentCacheService->updateAndGetCache($gift);
            }
        }


        $gifts = Gift::with('giftCache')->where('userId', $user->id)->get();

        $sortType = $request->get('sort');
        if (isset($sortType)) {
            switch ($sortType) {
                case SortConstants::PRIORITY:
                    $gifts = $gifts->sortBy('priority')->values();
                    break;
                case SortConstants::CREATED_AT_DESC:
                    $gifts = $gifts->sortByDesc('created_at')->values();
                    break;
                case SortConstants::CREATED_AT:
                    $gifts = $gifts->sortBy('created_at')->values();
                    break;
                case SortConstants::PRICE_HIGH:
                    $gifts = $gifts->sortByDesc('giftCache.price')->values();
                    break;

                case SortConstants::PRICE_LOW:
                    $gifts = $gifts->sortBy('giftCache.price')->values();
                    break;
                case SortConstants::RANDOM:
                    $gifts = $gifts->shuffle()->values();
                    break;
            }
        }

        return view('home', ['user' => $user,'gifts' => $gifts]);
    }
}
