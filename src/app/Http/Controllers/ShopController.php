<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SearchRequest;


class ShopController extends Controller
{
    public function index(Request $request)
    {
        $selectedArea = $request->old('area', '');
        $selectedGenre = $request->old('genre', '');
        $searchKeyword = $request->old('keyword', '');

        $shopQuery = Shop::query();

        if ($selectedArea) {
            $shopQuery->where('area', $selectedArea);
        }

        if ($selectedGenre) {
            $shopQuery->where('genre', $selectedGenre);
        }

        if ($searchKeyword) {
            $shopQuery->where(function ($query) use ($searchKeyword) {
                $query->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('area', 'like', "%{$searchKeyword}%")
                    ->orWhere('genre', 'like', "%{$searchKeyword}%");
            });
        }

        $shopList = $shopQuery->get();
        $loginUser = auth()->user();
        $favoriteShopIds = $loginUser ? $loginUser->favorites->pluck('id')->toArray() : [];

        $areaList = Shop::select('area')->distinct()->pluck('area');
        $genreList = Shop::select('genre')->distinct()->pluck('genre');

        return view('shops.index', compact('shopList', 'favoriteShopIds', 'areaList', 'genreList'));
    }

    public function search(SearchRequest $request)
    {
        return redirect()->route('shop.index')->withInput();
    }

    public function show($shopId)
    {
        $shop = Shop::findOrFail($shopId);
        return view('shops.show', compact('shop'));
    }

    public function toggleFavorite(Request $request)
    {
        $shopId = $request->input('shop_id');
        $loginUser = Auth::user();
        $redirectTo = $request->input('redirect_to', '/');

        if ($loginUser->favorites()->where('shop_id', $shopId)->exists()) {
            $loginUser->favorites()->detach($shopId);
        } else {
            $loginUser->favorites()->attach($shopId);
        }

        return redirect($redirectTo);
    }
}