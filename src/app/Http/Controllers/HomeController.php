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
                    $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'auto');
                    //DOMDocumentとDOMXpathの作成
                    $dom = new DOMDocument;
                    @$dom->loadHTML($html);
                    $xpath = new DOMXPath($dom);


                    $url = $gift->url;
                    $title = $xpath->query('//meta[@property="og:title"]/@content')->item(0)->nodeValue;
                    $description = $xpath->query('//meta[@property="og:description"]/@content')->item(0)->nodeValue;
                    $image = $xpath->query('//meta[@property="og:image"]/@content')->item(0)->nodeValue;
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
