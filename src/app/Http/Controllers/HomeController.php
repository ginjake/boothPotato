<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Gift;
use App\Models\User;
use App\Models\GiftCache;
use DOMDocument;
use DOMXPath;
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
        $userId = $request->get('id');
        if (empty($userId)) {
            if (!empty(Auth::user())) {
                $userId = Auth::user()->id;
            } else {
                $userId = 1;
            }
        }

        $user = User::find($userId);
        $gifts = Gift::where('userID', $userId)->get();


        //TODO UA偽装してOGPだけとりたいが、なんかうまく行ってない
        $ua = "User-Agent: Twitterbot/1.0";
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=>"$ua"
          )
        );

        $cacheBaseTime = new Carbon('-3 days');

        foreach ($gifts as $gift) {
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
        return view('home',['user' => $user,'gifts' => $gifts]);
    }
}
