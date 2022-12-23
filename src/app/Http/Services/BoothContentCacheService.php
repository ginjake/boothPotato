<?php
namespace App\Http\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gift;
use App\Models\GiftCache;
use Carbon\Carbon;
class BoothContentCacheService
{

    private $ua;
    private $option;

    /**
     * __construct
     *
     *
     * @return void
     */
    public function __construct()
    {
        $this->ua = "User-Agent: Twitterbot/1.0";
        $this->option = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"$this->ua"
            )
        );
    }

    public function updateAndGetCache(Gift $gift) {
        if ($this->checkCache($gift->giftCache)) {
            $saveData = $this->reloadCache($gift->url);
            $gift->giftCache = GiftCache::create($saveData);
        }
        return $gift->giftCache;
    }

    /**
     * キャッシュが有効か確認
     *
     * @param  ?GiftCache  $giftCache
     *
     * @return bool
     */
    public function checkCache(?GiftCache $giftCache) :bool{

        $cacheBaseTime = new Carbon('-3 days');

        //キャッシュがない
        if (empty($giftCache)) {
            return true;
        } else {
            //キャッシュが古い
            if ($giftCache->updated_at < $cacheBaseTime) {
                return true;
            }
        }

        return false;
    }

    /**
     * キャッシュを最新に更新
     *
     * @param  string  $url
     *
     * @return array
     */
    private function reloadCache(string $url) :array {
        GiftCache::where('url', $url)->delete();
        if ($html = @file_get_contents($url) ) {
            $html = file_get_contents($url, false, stream_context_create($this->option));

            preg_match('/<meta property="og:title" content="(.*?)"/', $html, $result);
            $title = $result[1];
            preg_match('/<meta property="og:image" content="(.*?)"/', $html, $result);
            $image = $result[1];
            preg_match('/<meta property="og:description" content="(.*?)"/', $html, $result);
            $description = $result[1];
        }
        return [
            'url' => $url,
            'title' => $title,
            'description' => $description,
            'image' => $image,
        ];
    }
}
