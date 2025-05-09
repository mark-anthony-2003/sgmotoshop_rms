<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Shipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('includes.header', function ($view) {
            $cartCount = 0;
            $carts = [];

            if (Auth::check() && Auth::user()->user_type === 'customer') {
                $carts = Cart::where('user_id', Auth::id())
                    ->whereNull('shipment_id')
                    ->with('item')
                    ->get();
                    
                $cartCount = $carts->count();
            }

            $view->with('cartCount', $cartCount)
                 ->with('carts', $carts);
        });
    }
}
