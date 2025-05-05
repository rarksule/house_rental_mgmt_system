<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\House;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $houses = House::where('rented', 0);

        // Address filter (like search)
        if ($request->has('address') && !empty($request->address)) {
            $houses->where('address', 'like', '%' . $request->address . '%');
        }

        // Min price filter
        if ($request->has('min_price') && !empty($request->min_price)) {
            $houses->where('price', '>=', (int) $request->min_price);
        }

        // Max price filter
        if ($request->has('max_price') && !empty($request->max_price)) {
            $houses->where('price', '<=', (int) $request->max_price);
        }

        $houses = $houses->orderBy('price')->get();

        return view('welcome', compact('houses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function cookie()
    {   
        $setting = Setting::find(1);
        $content = $setting ? $setting->cookie_policy : '';
        return view('common.cookie',compact(['content']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function privacy()
    {
        
        $setting = Setting::find(1);
        $content = $setting ? $setting->privacy_policy : '' ;
        return view('common.cookie',compact(['content']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function terms()
    {
        
        $setting = Setting::find(1);
        $content = $setting ?  $setting->terms_conditions : '';
        return view('common.cookie',compact(['content']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $house = House::find($id);
        return view('tenant.house_detail', compact('house'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
