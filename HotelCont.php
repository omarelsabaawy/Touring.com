<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hotels;

class HotelCont extends Controller
{
    function hotelProfile($id)
    {
        $hotel = hotels::find($id);
        return view('hotelProfile')->with(['hotel'=>$hotel]);
    }

}
