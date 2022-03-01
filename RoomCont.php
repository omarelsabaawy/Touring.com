<?php

namespace App\Http\Controllers;;

use App\persons;
use Illuminate\Http\Request;
use App\rooms;
use App\booking;

class RoomCont extends Controller
{

    function stays(){
        $data = rooms::all();
        return view('listRooms')->with(['data'=>$data]);
    }

    function show($id){
        $data = rooms::find($id);
        return view('Room')->with(['data'=>$data]);
    }

    function booking(Request $request){
        $room = new booking();
        $room->fname = $request->input('fname');
        $room->lname = $request->input('lname');
        $room->starts = $request->input('starts');
        $room->end = $request->input('end');
        $room->children = $request->input('children');
        $room->adults = $request->input('adults');
        $room->Nrooms = $request->input('Nrooms');
        $room->roomId = $request->input('roomId');
        $room->HotelName = $request->input('HotelName');
        $room->price = $request->input('price');
        $room->save();
        return redirect('stays');
    }
    function hotelRooms(){
        $data = rooms::all();
        return view('hotelRooms')->with(['data'=>$data]);
    }

}
