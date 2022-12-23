<?php
namespace App\Http\Services;

use App\Models\Category;
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
            if (empty($giftCache->price)) {
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
        preg_match('/items\/(.*)/', $url, $item);
        $combinedUrl = "https://booth.pm/ja/items/".$item[1];

        GiftCache::where('url', $url)->delete();

        if ($html = @file_get_contents($combinedUrl.'.json')) {

            $content = json_decode($html);


            Category::firstOrCreate([
                    'id' => $content->category->id
                ],
                [
                    'id' => $content->category->id,
                    'name' => $content->category->name,
                    'url' => $content->category->url
                ],
            );
            return [
                'categoryId' => $content->category->id,
                'url' => $url,
                'boothUrl' => $content->url,
                'title' => $content->name,
                'price' => $content->variations[0]->price,
                'image' => $content->images[0]->original,
                'description' => $content->description,
            ];
        } else {
            abort(500);
        }
    }
}
