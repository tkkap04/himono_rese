<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();
        $query = Shop::query();

        $searchParams = [];
        $sort = null;

        if ($request->filled('area')) {
            $query->where('area_id', $request->area);
            $searchParams['area'] = Area::find($request->area)->name;
        }

        if ($request->filled('genre')) {
            $query->where('genre_id', $request->genre);
            $searchParams['genre'] = Genre::find($request->genre)->name;
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
            $searchParams['search'] = $request->search;
        }

        if ($request->filled('sort')) {
            $sort = $request->sort;

            if ($request->sort === 'random') {
                $query->inRandomOrder();
            } elseif ($request->sort === 'high_rating') {
                $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
            } elseif ($request->sort === 'low_rating') {
            $query->withAvg('reviews', 'rating')
                  ->orderByRaw('CASE WHEN reviews_avg_rating IS NULL THEN 1 ELSE 0 END')
                  ->orderBy('reviews_avg_rating', 'asc'); 
            }
        }

        $shops = $query->get();
        $user = Auth::user();

        return view('list', compact('shops', 'areas', 'genres', 'user', 'sort', 'searchParams'));
    }

    public function detail($id)
    {
        $shop = Shop::with(['genre', 'reviews'])->findOrFail($id);

        $reviews = $shop->reviews;
        $hasUserReview = $reviews->contains('user_id', Auth::id());

        $averageRating = $reviews->avg('rating');

        return view('detail', compact('shop', 'reviews', 'averageRating', 'hasUserReview'));
    }
}
