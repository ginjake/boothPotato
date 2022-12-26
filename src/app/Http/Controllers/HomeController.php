<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GiftCache;
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
            $twitterId = 125591316;
        }
        if (empty($twitterId)) {
            if (!empty(Auth::user())) {
                $twitterId = Auth::user()->twitterId;
            } else {
                $twitterId = 125591316;
            }
        }

        $user = User::where('twitterId', $twitterId)->first();

        if (isset($user->gifts)) {
            foreach ($user->gifts as $gift) {
                $boothContentCacheService = new BoothContentCacheService();
                $gift->giftCache = $boothContentCacheService->updateAndGetCache($gift);
            }
        }
        return view('home',['user' => $user]);
    }
}
