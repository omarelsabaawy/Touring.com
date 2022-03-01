<?php

namespace App\Http\Controllers;

use App\hotels;
use App\persons;
use Illuminate\Http\Request;

class MangerCont extends Controller
{
    function hotels(){
        $hotels = hotels::all();
        return view('listHotels')->with(['hotels'=>$hotels]);
    }
    function users(){
        $users = persons::all();
        return view('listUsers')->with(['users'=>$users]);
    }
    function deleteUser($id){
        $users = persons::find($id);
        $users->delete();
        return redirect('/users');
    }
    function deleteHotel($id){
        $hotel = hotels::find($id);
        $hotel->delete();
        return redirect('/hotels');
    }
}
