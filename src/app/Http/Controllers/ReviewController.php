<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Shop;

use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($shopId)
    {
        $shop = Shop::with(['area', 'genre'])->findOrFail($shopId);

        return view('create', compact('shop'));
    }

    /* 新規口コミの作成 */
    public function store(ReviewRequest $request, $shopId)
    {
        $existingReviewsCount = Review::where('shop_id', $shopId)
            ->where('user_id', Auth::id())
            ->count();

        if ($existingReviewsCount >= 2) {
            return redirect()->route('shop.detail', ['id' => $shopId])
                ->withErrors('1店舗につき最大2件まで口コミを投稿できます。');
        }

        $imagePath = $request->file('image') ? $request->file('image')->store('reviews', 'public') : null;

        Review::create([
            'shop_id' => $shopId,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('shop.detail', ['id' => $shopId])
            ->with('success', '口コミを投稿しました。');
    }

    /* 口コミの編集画面を表示 */
    public function edit($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        $shop = $review->shop;
        if ($review->user_id !== Auth::id()) {
            abort(403, '権限がありません。');
        }

        return view('create', compact('review', 'shop'));
    }

    /* 口コミの更新 */
    public function update(ReviewRequest $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);

        if ($review->user_id !== Auth::id()) {
            abort(403, '権限がありません。');
        }

        $imagePath = $request->file('image') ? $request->file('image')->store('reviews', 'public') : $review->image_url;

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('shop.detail', ['id' => $review->shop_id])
            ->with('success', '口コミを更新しました。');
    }

    /* 口コミの削除 */
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, '権限がありません。');
        }

        $review->delete();

        return redirect()->route('shop.detail', ['id' => $review->shop_id])
            ->with('success', '口コミを削除しました。');
    }
}
