<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Forum;
use App\Models\Forum_Comment;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $posts = DB::select('select Forum.id, Title, Date, HasAttachments, Username from forum
        join Users on author = Users.id
        order by Date');//TODO:Possibly a different method?
        //TODO:Fix ordering
        return view('Forum', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Forum_new");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$forum = new Forum();
        $forum->
        $forum->save();*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = DB::select("SELECT Forum.id, Title, Date, Message, HasAttachments, Users.Username
        FROM Forum
        JOIN Users on Users.id = Author
        WHERE forum.id = $id");

        $thread = DB::select("SELECT forum_comments.id, Users.Username, Date, Message, HasAttachments
        FROM forum_comments
        JOIN users ON users.id = forum_comments.Author
        WHERE Post = $id");

        return view('ForumThread', compact('post'), compact('thread'));
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
