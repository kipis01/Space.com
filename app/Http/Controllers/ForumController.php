<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $posts = DB::select('select Forum.id, Title, forum.created_at, HasAttachments, Username from forum
        join Users on author = Users.id
        order by forum.created_at');//TODO:Possibly a different method?
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
        //
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
            'title' => 'required',
            'message' => 'required',
            /*'file1' => 'image|max:1024|nullable',
            'file2' => 'image|max:1024|nullable',
            'file3' => 'image|max:1024|nullable',*///FIXME:Validation fails on pics?
        ]);

        $pic = $request->file('file1');

        $forum = new Forum();
        $forum->title = $request->title;
        $forum->Author = Auth::user()->id;
        $forum->message = $request->message;
        $forum->save();
        mkdir("forum_data/$forum->id");
        for ($i = 1; $i <= 3; $i++){
            $file = $request->file("file$i");
            if($file != NULL){
                $forum->HasAttachments = true;
                $file->move("forum_data/$forum->id", $file->getClientOriginalName());
            }
        }
        $forum->save();
        return redirect('/forum');
    }

    public function storeComment($id, Request $request){
        $request->validate([
            'message' => 'required'
        ]);
        if (Forum::find($id) == null)
            return response(403);

        $comment = new Forum_Comment();
        $comment->Post = $id;
        $comment->message = $request->message;
        $comment->Author = Auth::user()->id;
        $comment->save();
        mkdir("forum_data/$id/$comment->id");
        for ($i = 1; $i <= 3; $i++){
            $file = $request->file("file$i");
            if($file != NULL){
                $comment->HasAttachments = true;
                $file->move("forum_data/$id/$comment->id", $file->getClientOriginalName());
            }
        }
        $comment->save();
        return redirect("/forum/$id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = DB::select("SELECT Forum.id, Title, forum.created_at, Message, HasAttachments, Users.Username
        FROM Forum
        JOIN Users on Users.id = Author
        WHERE forum.id = $id");

        $thread = DB::select("SELECT forum_comments.id, Users.Username, forum_comments.created_at, Message, HasAttachments
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
