<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.navbar-2', function ($view) {
            $carts = Cart::with('product')->where('user_id', auth()->id())->get();

            $cartTotal = $carts->sum(function ($cart) {
                return $cart->product->price * $cart->quantity;
            });

            $cartCount = $carts->sum('quantity');

            $view->with(compact('cartTotal', 'cartCount'));
        });
    }

    public function register()
    {
        //
    }
}
