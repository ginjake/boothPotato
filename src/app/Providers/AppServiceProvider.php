<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {


        view()->composer('*', function ($view) use ($request) {

            if (empty(Auth::user())) {
                return;
            }
            $sort = $request->get('sort');

            $url = url()->current();
            $url = $url.'?id='.Auth::user()->twitterId;
            if (isset($sort)) {
                $url = $url.'&sort='.$sort;
            }
            $url = $url.' #booth欲しいモノリスト';

            view()->share('twitterURL', urlencode($url));
        });

    }
}
