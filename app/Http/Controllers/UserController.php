<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Storage;
use File;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

include_once '../resources/php/functions.php';

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::select("SELECT id, Username, Role, created_at FROM Users");
        return view('UserList', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = DB::select("SELECT id, Username, Role, created_at FROM users WHERE id = $id");
        $forumPosts = DB::select("SELECT id, Title, created_at, Message, HasAttachments FROM forum WHERE Author = $id ORDER BY created_at");
        $forumComments = DB::select("SELECT id, Post, created_at, Message, HasAttachments FROM Forum_comments where Author = $id");
        //TODO:Add wiki and News, when those are finished
        return view('UserProfile', [
            'profile' => $profile,
            'forumPosts' => $forumPosts,
            'forumComments' => $forumComments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::select("SELECT id, Username, Role FROM Users WHERE id = $id");
        return view("Settings", compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {//TODO:Add email changing adn clean this up
        $phash = DB::select("SELECT Password FROM Users WHERE id =".Auth::user()->id);
        if (!Hash::check($request->pass, $phash[0]->Password)){
            return view('404'); //TODO: Add an error screen
        }

        $validator = Validator::make($request->all(), ['nickname' => 'unique:users,Username']);
        if ($validator->fails() && $request->nickname != '')
            return view('404');
        else if ($request->nickname != ''){
            DB::update("UPDATE Users SET Username = '$request->nickname', updated_at = '".Carbon::now()."' WHERE id = $id");
        }

        /*$validatedData = $request->validate([
         'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);*/

        $file = $request->file('pfp');
        if ($file != null){
            unlink("Users/$id/".findpfp("Users/$id"));
            $file->move("Users/$id", "pfp.".$file->getClientOriginalExtension());
            DB::update("UPDATE Users SET updated_at = '".Carbon::now()."' WHERE id = $id");
        }

        if ($request->pass1 == $request->pass2 && $request->pass1 != ''){
            DB::update("UPDATE Users SET Password = '".Hash::make($request->pass1)."', updated_at = '".Carbon::now()."' WHERE id = $id");
        }

        $user = DB::select("SELECT Role FROM users WHERE id = $id");
        if($request->role != null && $request->role != $user[0]->Role){
            DB::update("UPDATE Users SET Role = '$request->role', updated_at = '".Carbon::now()."' WHERE id = $id");
        }

        return redirect("/user/$id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id)
            Auth::logout();
        DB::delete("DELETE FROM News_Comments WHERE Author = $id");
        DB::delete("DELETE FROM News WHERE Author = $id");
        DB::delete("DELETE FROM Forum_Comments WHERE Author = $id");
        DB::delete("DELETE FROM Forum WHERE Author = $id");
        DB::delete("DELETE FROM Wiki_Contributors WHERE Contributor = $id");
        DB::delete("DELETE FROM Wiki WHERE Author = $id");
        DB::delete("DELETE FROM Users WHERE id = $id");
        File::deleteDirectory(public_path()."/Users/$id");
        return redirect('/');
    }
}
