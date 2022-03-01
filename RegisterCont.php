<?php

namespace App\Http\Controllers;

use App\hotels;
use App\rooms;
use App\persons;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use phpDocumentor\Reflection\DocBlock\Tags\Uses;
use phpDocumentor\Reflection\Types\True_;

class RegisterCont extends Controller
{
    function register(Request $request)
    {
        $user = new persons();
        $user->admin = 0;
        $user->username = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Crypt::encrypt($request->input('password'));
        $how = persons::where('email', '=', $request->input('email'))->first();
        $howa = persons::where('username', '=', $request->input('name'))->first();
        if ($how != null || $howa != null) {
            return redirect('register');
        } else {
            $user->save();
            return redirect('/login');
        }
    }

    function login(Request $request)
    {
        $person = persons::where('email', $request->input('email'))->get();
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:persons',
            'password' => 'required|string'
        ]);

        if ($person[0]->admin == 1){
            $request->session()->put('Manager', $person[0]->username);
            return redirect('/');
        }

        if ($validator->fails()) {

            $request->session()->flash('message', 'Email Does Not Exists');
            $validator->errors()->add('field', 'Something is wrong with this field!');
            return redirect('/login');
            // return redirect('register')->withErrors($validator, 'login');
        } else {
            if ($person[0]->email == $request->input('email')) {
                if (Crypt::decrypt($person[0]->password) == $request->input('password')) {
                    $request->session()->put('person', $person[0]->username);
                    return redirect('/');
                } else {
                    return redirect('/login');
                }
            }

        }
    }

    function edit(Request $request)
    {
        $data = persons::all();
        return view('profile')->with(['data' => $data]);
    }

    function logout(Request $request)
    {
        $request->session()->forget('person');
        $request->session()->forget('name');
        return redirect('/');
    }

    function logoutHotel(Request $request)
    {
        $request->session()->forget('hotel');
        $request->session()->forget('hotel_name');
        return redirect('/');
    }
    function logoutManager(Request $request)
    {
        $request->session()->forget('Manager');
        $request->session()->forget('name');
        return redirect('/');
    }

    function register_rooms1(Request $request)
    {
        $room1 = new rooms();
        $room1->id = $request->input('room_id');
        $room1->hotel_id = $request->input('hotel_id');
        $room1->available = $request->input('available');
        $room1->type = $request->input('type');
        $room1->floor = $request->input('floor');
        $room1->price = $request->input('price');
        $room1->additional_notes = $request->input('additional_notes');
        $room1->image = $request->input('image');
        $room1->save();
        return redirect('/roomRegister');
    }

    function register_hotels(Request $request)
    {
        $user = new hotels();
        $user->id = $request->input('hotel_id');
        $user->hotel_name = $request->input('hotel_name');
        $user->location = $request->input('location');
        $user->type = $request->input('type');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->image = $request->input('image');
        $user->additional_notes = $request->input('additional_notes');
        $user->save();
        if(true){
            $request->session()->put('hotel', $user->hotel_name);
            $request->session()->put('hotelID', $user->id);
        }
        return redirect('/');
    }
}
