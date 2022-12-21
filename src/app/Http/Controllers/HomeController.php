<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GiftCache;
use Carbon\Carbon;
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

        //TODO UA偽装してOGPだけとりたいが、なんかうまく行ってない
        $ua = "User-Agent: Twitterbot/1.0";
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"$ua"
          )
        );

        $cacheBaseTime = new Carbon('-3 days');

        if (isset($user->gifts)) {
            foreach ($user->gifts as $gift) {
                $cacheReload = false;
                //キャッシュがない
                if (empty($gift->giftCache)) {
                    $cacheReload = true;
                } else {
                    //キャッシュが古い
                    if ($gift->giftCache->updated_at < $cacheBaseTime) {
                        $cacheReload = true;
                    }
                }

                if ($cacheReload) {
                    GiftCache::where('url', $gift->url)->delete();

                    if ($html = @file_get_contents($gift->url) ) {
                        $html = file_get_contents($gift->url, false, stream_context_create($opts));

                        $url = $gift->url;
                        preg_match('/<meta property="og:title" content="(.*?)"/', $html, $result);
                        $title = $result[1];
                        preg_match('/<meta property="og:image" content="(.*?)"/', $html, $result);
                        $image = $result[1];
                        preg_match('/<meta property="og:description" content="(.*?)"/', $html, $result);
                        $description = $result[1];

                        $gift->giftCache = GiftCache::create(
                            [
                                'url' => $url,
                                'title' => $title,
                                'description' => $description,
                                'image' => $image,
                            ]
                        );
                    }
                }
            }
        }
        return view('home',['user' => $user]);
    }
}
