<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function storeReview(Request $request, $shopId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'shop_id' => $shopId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('shop.detail', ['id' => $shopId] );
    }

    public function show($shopId)
    {
        $shop = Shop::with('reviews.user')->findOrFail($shopId);
        $averageRating = $shop->reviews()->avg('rating');

        return view('detail', compact('shop', 'averageRating'));
    }
}
