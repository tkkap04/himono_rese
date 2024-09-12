<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        Favorite::create([
            'user_id' => Auth::id(),
            'shop_id' => $request->shop_id,
        ]);

        return redirect()->back();
    }

    public function destroy(Shop $shop)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', Auth::id())
                            ->where('shop_id', $shop->id)
                            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return redirect()->back();
    }
}
