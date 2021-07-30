<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use \Auth;

class ImageController extends Controller
{
    public function upload(Request $reqest)
    {   
        if (Auth::user()->avatar != NULL){
            unlink(public_path(Auth::user()->avatar));
        }
        if ($reqest->file('image') != ''){
            $path = $reqest->file('image')->store('uploads', 'public');
            $dbPath = "/storage/" . $path;
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['avatar' => $dbPath]);     
        } else {
            $path = '';
        }
        return view('downloadNewPhoto', ['path' => $path]);
    }
    
    public function delete()
    {
        if (Auth::user()->avatar != NULL){
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['avatar' => NULL]);
            unlink(public_path(Auth::user()->avatar));
        }
        return redirect("home");
    }
}
