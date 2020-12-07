<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Season;
use App\Dish;
use App\User;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $user = Auth::user();
        $dishes = Dish::all();
        $seasons = Season::all();

        if(Auth::check()) {
            return view('admin.seasons.index', compact('seasons', 'user', 'dishes'));
        } else {
            return view('guest.seasons.index', compact('seasons'));
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $dishes = Dish::all();

        return view('admin.seasons.create',compact('dishes', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|max:255',
            'method'=> 'required',
            'season_id'=> 'required|min:1|max:4',
            'type'=> 'required|max:255',
            'price'=> 'required|max:999,99',
            'image'=> 'required|image',
        ]);

        if (Auth::check()) {
            $request_data = $request->all();
      
            $new_dish = new Dish();
            // $new_dish->user_id = Auth::id();
            $new_dish->name = $request_data['name'];
            $new_dish->method = $request_data['method'];
            $new_dish->season_id = $request_data['season_id'];
            $new_dish->type = $request_data['type'];
            $new_dish->price = $request_data['price'];
            $new_dish->image = $request_data['image'];
            $saved_dish = $new_dish->save();
        }
        
        if ($saved_dish) {
            return redirect()->route('admin.seasons.show', $saved_dish);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Season $season)
    {
        $dishes = Dish::all();
        $user_id = Auth::id();
        $user = Auth::user();
        if (Auth::check()) {
            return view('admin.seasons.show', compact('season', 'dishes', 'user'));
        } else {
            return view('guest.seasons.show', compact('season', 'dishes'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
