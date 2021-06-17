<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\News;
use App\Models\News_Comment;
use App\Models\User;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = News::with('User')->orderByDesc('created_at')->get()->toArray();
        $pics = [];
        foreach ($articles as $i) {
           $pics[$i['id']] = simplexml_load_file("../public/news_data/".$i['id']."/index.xml")->head->pic;
        }
        return view("News", ['articles' => $articles, 'pics' => $pics]);
    }

    public function search(Request $request){
        $articles = News::where("Title", "LIKE", "%$request->search%")->with('User')->orderByDesc('created_at')->get()->toArray();
        $pics = [];
        foreach ($articles as $i) {
           $pics[$i['id']] = simplexml_load_file("../public/news_data/".$i['id']."/index.xml")->head->pic;
        }
        return view("News", ['articles' => $articles, 'pics' => $pics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('NewArticle');
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
            'main_title' => 'required',
            'main_pic' => 'required|image',
            'main_text' => 'required',
            'count' => 'numeric'
        ]);

        $article = News::create([
            'Title' => $request->main_title,
            'Author' => Auth::user()->id
        ]);

        mkdir("../public/news_data/$article->id");
        $img = $request->file("main_pic");
        $img->move("../public/news_data/$article->id", $img->getClientOriginalName());

        $dom = new \domDocument('1.0', 'UTF-8');
        $root = $dom->appendChild($dom->createElement('article'));
        $head = $dom->createElement('head');
        $root->appendChild($head);
        $head->appendChild($dom->createElement('pic', $img->getClientOriginalName()));
        $head->appendChild($dom->createElement('text', $request->main_text));
        $head->appendChild($dom->createElement('elementc', $request->count));
        $content = $dom->createElement('content');
        $root->appendChild($content);

        for ($i = 1; $i <= $request->count; $i++){
            if ($request["a$i"] != null){
                $elem = $dom->createElement("d$i", $request["p$i"]);
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'a'));
                $elem->appendChild($dom->createElement('href', $request["a$i"]));
            }else if ($request["f$i"] != null){
                $file = $request->file("f$i");
                $file->move("../public/news_data/$article->id", $file->getClientOriginalName());

                $elem = $dom->createElement("d$i", $file->getClientOriginalName());
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'img'));
                $elem->appendChild($dom->createElement('alt', $request["p$i"]));
            }else if ($request["p$i"] != null){
                $elem = $dom->createElement("d$i", $request["p$i"]);
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'p'));
                if ($request['a'.$i-1] != null && $request['a'.$i+1] != null)
                    $elem->appendChild($dom->createElement('a', '-2'));
                else if ($request['a'.$i-1] != null)
                    $elem->appendChild($dom->createElement('a', '-1'));
                else if ($request['a'.$i+1] != null)
                    $elem->appendChild($dom->createElement('a', '1'));
                else $elem->appendChild($dom->createElement('a', '0'));
            }
        }
        $dom->save("../public/news_data/$article->id/index.xml");

        return redirect("/news/$article->id");
    }

    public function storeComment($id, Request $request){
        $request->validate(['message' => 'required']);

        News_Comment::create([
            'Author' => Auth::user()->id,
            'Article' => $id,
            'Message' => $request->message
        ]);
        return redirect("news/$id");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = News::find($id);
        if ($article == null)
            return abort(404);
        $article->Views++;
        $article->save();

        $article = News::where('id', $id)->with('User')->get()->toArray()[0];
        $xml = simplexml_load_file("../public/news_data/$id/index.xml");
        $comments = News_Comment::where('Article', $id)->orderByDesc('created_at')->with('User')->get()->toArray();
        return view("Article", ['article' => $article, 'xml' => $xml, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (News::where('id', $id)->first()->toArray()['Author'] != Auth::user()->id && Auth::user()->role != 'Admin')
            return abort(403);

        $article = (object)News::where('id', $id)->get()->toArray()[0];
        $xml = simplexml_load_file("../public/news_data/$id/index.xml");
        return view('NewArticle', ['article' => $article, 'xml' => $xml]);
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
        if (News::where('id', $id)->first()->toArray()['Author'] != Auth::user()->id && Auth::user()->role != 'Admin')
            return abort(403);

        $request->validate([
            'main_title' => 'required',
            'main_pic' => 'nullable|image',
            'main_text' => 'required',
            'count' => 'numeric'
        ]);

        $article = News::where('id', $id)->first();
        $article->Title = $request->main_title;
        $article->save();

        $xml = simplexml_load_file("../public/news_data/$id/index.xml");

        $img = $request->file("main_pic");
        $imgName = $xml->head->pic[0];
        if ($img != null){
            unlink("../public/news_data/".$xml->head->pic);
            $img->move("../public/news_data/$article->id", $img->getClientOriginalName());
            $imgName = $img->getClientOriginalName();
        }

        $dom = new \domDocument('1.0', 'UTF-8');
        $root = $dom->appendChild($dom->createElement('article'));
        $head = $dom->createElement('head');
        $root->appendChild($head);
        $head->appendChild($dom->createElement('pic', $imgName));
        $head->appendChild($dom->createElement('text', $request->main_text));
        $head->appendChild($dom->createElement('elementc', $request->count));
        $content = $dom->createElement('content');
        $root->appendChild($content);

        for ($i = 1; $i <= $request->count; $i++){
            if ($request["a$i"] != null){
                $elem = $dom->createElement("d$i", $request["p$i"]);
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'a'));
                $elem->appendChild($dom->createElement('href', $request["a$i"]));
            }else if ($request["f$i"] != null){
                $file = $request->file("f$i");
                $file->move("../public/news_data/$article->id", $file->getClientOriginalName());

                $elem = $dom->createElement("d$i", $file->getClientOriginalName());
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'img'));
                $elem->appendChild($dom->createElement('alt', $request["p$i"]));
            }else if ($request["p$i"] != null){
                $elem = $dom->createElement("d$i", $request["p$i"]);
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'p'));
                if ($request['a'.$i-1] != null && $request['a'.$i+1] != null)
                    $elem->appendChild($dom->createElement('a', '-2'));
                else if ($request['a'.$i-1] != null)
                    $elem->appendChild($dom->createElement('a', '-1'));
                else if ($request['a'.$i+1] != null)
                    $elem->appendChild($dom->createElement('a', '1'));
                else $elem->appendChild($dom->createElement('a', '0'));
            }else{
                $elem = $dom->createElement("d$i", $xml->xpath("content/d$i")[0]);
                $content->appendChild($elem);
                $elem->appendChild($dom->createElement('type', 'img'));
                $elem->appendChild($dom->createElement('alt', $xml->xpath("content/d$i/alt")[0]));
            }
        }
        unlink("../public/news_data/$article->id/index.xml");
        $dom->save("../public/news_data/$article->id/index.xml");

        return redirect("/news/$article->id");
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
