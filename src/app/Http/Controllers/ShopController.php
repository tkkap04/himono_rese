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

        $shops = $query->get();
        $user = Auth::user();

        return view('list', compact('shops', 'areas', 'genres', 'user', 'searchParams'));
    }

    public function detail($id)
    {
        $shop = Shop::with('genre')->findOrFail($id);
        $reviews = $shop->reviews;

        $averageRating = $reviews->avg('rating');

        return view('detail', compact('shop', 'reviews', 'averageRating'));
    }
}
