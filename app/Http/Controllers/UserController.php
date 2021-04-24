<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$users = User::all();
        return view('', $users);*/
        //TODO: Finish this
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usernames = DB::select('select Username from Users');
        return view("Register", compact('usernames'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['nickname' => 'unique:users,Username']);//TODO:Add other checks
        $profile = new User();
        $profile->Username = $request->nickname;
        $profile->Password = Hash::make($request->pass);

        $time = Carbon::now();
        $profile->created_at = $time;
        $profile->updated_at = $time;

        $profile->save();
        $error = 0;
        return view('Login', compact('error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {//TODO:finish this
        return view('UserProfile');
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

    public function loginScreen(){//TODO:Finish this
        $error = 0;
        return view('Login', compact('error'));
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), ['nickname' => 'exists:users,Username']);
        if ($validator->fails()) {
            $error = 1;
            return view('Login', compact('error'));
        }else{
            $phash = DB::select("SELECT Password FROM Users WHERE Username = '$request->nickname'");
            if (!Hash::check($request->pass, $phash[0]->Password)){
                $error = 1;
                return view('Login', compact('error'));
            }
        }
        if (Auth::attempt(['Username' => $request->nickname, 'password' => $request->pass]))
            return view('UserProfile');
    }

    public function logout(Request $request){
        Auth::logout();
        return view('Temp');//TODO:To be replaced with a redirect to news
    }
}
