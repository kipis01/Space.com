<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Wiki;
use App\Models\Wiki_Contributor;

class WikiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Wiki::orderByDesc('Views')->get()->toArray();
        $pics = [];
        foreach ($articles as $i){
            $pics[$i['id']] = simplexml_load_file("../public/wiki_data/".$i['id'].'/'.$i['Version'].'.xml')->head->pic;
        }
        return view('wiki', ['articles' => $articles, 'pics' => $pics]);
    }

    public function search(Request $request)
    {
        $articles = Wiki::where('Title', 'LIKE', "%$request->search%")->orderByDesc('Views')->get()->toArray();
        $pics = [];
        foreach ($articles as $i){
            $pics[$i['id']] = simplexml_load_file("../public/wiki_data/".$i['id'].'/'.$i['Version'].'.xml')->head->pic;
        }
        return view('wiki', ['articles' => $articles, 'pics' => $pics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('NewWiki');
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
            'main_pic' => 'required|image',
            'main_txt' => 'required'
        ]);

        $wiki = Wiki::create([
            'Title' => $request->title,
            'Author' => Auth::user()->id
        ]);

        Wiki_Contributor::create([
            'Article' => $wiki->id,
            'Contributor' => Auth::user()->id,
            'Version' => 1
        ]);

        mkdir("../public/wiki_data/$wiki->id");
        $img = $request->file('main_pic');
        $img->move("../public/wiki_data/$wiki->id", $img->getClientOriginalName());

        $dom = new \domDocument('1.0', 'UTF-8');
        $root = $dom->appendChild($dom->createElement('article'));
        $head = $dom->createElement('head');
        $root->appendChild($head);
        $head->appendChild($dom->createElement('pic', $img->getClientOriginalName()));
        $content = $dom->createElement('content');
        $root->appendChild($content);

        $content->appendChild($stats = $dom->createElement('stats'));
        for ($i = 1; $request["sname$i"] != null || $request["shr$i"] != null; $i++){
            if ($request["sname$i"] != null){
                $stats->appendChild($elem = $dom->createElement("d$i"));
                $elem->appendChild($dom->createElement('name', $request["sname$i"]));
                $elem->appendChild($dom->createElement('data', $request["sdata$i"]));
            }else{
                $stats->appendChild($dom->createElement("d$i", 'hr'));
            }
        }

        $content->appendChild($topics = $dom->createElement('topics'));
        $topics->appendChild($dom->createElement('d1', $request->main_txt));
        for ($i = 2; $request["ttopic$i"] != null; $i++){
            $topics->appendChild($big = $dom->createElement("d$i"));
            $big->appendChild($dom->createElement('title', $request["ttopic$i"]));
            for ($k = 1; $request["smallTitle$i"."_$k"] != null || $request["smallFileTitle$i"."_$k"] != null; $k++){
                if ($request["smallTitle$i"."_$k"] != null){
                    $big->appendChild($smelem = $dom->createElement("d$k", $request["smallText$i"."_$k"]));
                    $smelem->appendChild($dom->createElement("title", $request["smallTitle$i"."_$k"]));
                }else{
                    $file = $request->file("smallFile$i"."_$k");
                    $file->move("../public/wiki_data/$wiki->id", $file->getClientOriginalName());
                    $big->appendChild($smelem = $dom->createElement("d$k", $file->getClientOriginalName()));
                    $smelem->appendChild($dom->createElement("type", 'img'));
                    $smelem->appendChild($dom->createElement("desc", $request["smallFileTitle$i"."_$k"]));
                    $smelem->appendChild($dom->createElement('alt', $request["smallFileAlt$i"."_$k"]));
                }
            }
        }

        $content->appendChild($references = $dom->createElement('references'));
        for ($i = 1; $request["ref$i"] != null; $i++){
            $references->appendChild($elem = $dom->createElement("d$i", $request["reft$i"]));
            $elem->appendChild($dom->createElement("href", $request["ref$i"]));
        }
        $dom->save("../public/wiki_data/$wiki->id/1.xml");

        return redirect("/wiki/$wiki->id/v1");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $vid)
    {
        $article = Wiki::where('id', $id);
        if ($article == null)
            return abort(404);
        $article = (object)$article->get()->toArray()[0];
        if ($article->Version < $vid || $vid < 1)
            return abort(404);

        $temp = Wiki::where('id', $id)->first();
        $temp->Views = $temp->Views + 1;
        $temp->save();

        $xml = simplexml_load_file("../public/wiki_data/$article->id/$vid.xml");
        return view('WikiArticle', ['article' => $article, 'xml' => $xml]);
    }

    public function showVers($id){
        $article = Wiki::where('id', $id);
        if ($article == null)
            return abort(404);
        $article = (object)$article->with('Wiki_Contributor')->get()->toArray()[0];
        $users = Wiki_Contributor::where('Article', $id)->with('Wiki')->with('User')->get()->toArray();
        return view('AllWikiVersions', ['article' => $article, 'users' => $users]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = (object)Wiki::where('id', $id)->get()->toArray()[0];
        $xml = simplexml_load_file("../public/wiki_data/$article->id/$article->Version.xml");
        return view('NewWiki', ['article' => $article, 'xml' => $xml]);
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
        $request->validate([
            'title' => 'required',
            'main_pic' => 'nullable|image',
            'main_txt' => 'required'
        ]);

        $wiki = Wiki::where('id', $id)->first();
        $wiki->Title = $request->title;
        $wiki->Version = $wiki->Version + 1;
        $wiki->save();
        $wiki = (object)Wiki::where('id', $id)->get()->toArray()[0];

        Wiki_Contributor::create([
            'Article' => $wiki->id,
            'Contributor' => Auth::user()->id,
            'Version' => $wiki->Version + 1
        ]);

        $xml = simplexml_load_file("../public/wiki_data/$wiki->id/".($wiki->Version - 1).".xml");
        $img = $request->file('main_pic');
        $imgName = $xml->head->pic;
        if ($img != null){
            $img->move("../public/wiki_data/$wiki->id", $img->getClientOriginalName());
            $imgName = $img->getClientOriginalName();
        }

        $dom = new \domDocument('1.0', 'UTF-8');
        $root = $dom->appendChild($dom->createElement('article'));
        $head = $dom->createElement('head');
        $root->appendChild($head);
        $head->appendChild($dom->createElement('pic', $imgName));
        $content = $dom->createElement('content');
        $root->appendChild($content);

        $content->appendChild($stats = $dom->createElement('stats'));
        for ($i = 1; $request["sname$i"] != null || $request["shr$i"] != null; $i++){
            if ($request["sname$i"] != null){
                $stats->appendChild($elem = $dom->createElement("d$i"));
                $elem->appendChild($dom->createElement('name', $request["sname$i"]));
                $elem->appendChild($dom->createElement('data', $request["sdata$i"]));
            }else{
                $stats->appendChild($dom->createElement("d$i", 'hr'));
            }
        }

        $content->appendChild($topics = $dom->createElement('topics'));
        $topics->appendChild($dom->createElement('d1', $request->main_txt));
        for ($i = 2; $request["ttopic$i"] != null; $i++){
            $topics->appendChild($big = $dom->createElement("d$i"));
            $big->appendChild($dom->createElement('title', $request["ttopic$i"]));
            for ($k = 1; $request["smallTitle$i"."_$k"] != null || $request["smallFileTitle$i"."_$k"] != null || isset($request["smallcount$i"])?$k <= $request["smallcount$i"]:false; $k++){
                if ($request["smallTitle$i"."_$k"] != null){
                    $big->appendChild($smelem = $dom->createElement("d$k", $request["smallText$i"."_$k"]));
                    $smelem->appendChild($dom->createElement("title", $request["smallTitle$i"."_$k"]));
                }else if ($request["smallFileTitle$i"."_$k"] != null){
                    $file = $request->file("smallFile$i"."_$k");
                    $file->move("../public/wiki_data/$wiki->id", $file->getClientOriginalName());
                    $big->appendChild($smelem = $dom->createElement("d$k", $file->getClientOriginalName()));
                    $smelem->appendChild($dom->createElement("type", 'img'));
                    $smelem->appendChild($dom->createElement("desc", $request["smallFileTitle$i"."_$k"]));
                    $smelem->appendChild($dom->createElement('alt', $request["smallFileAlt$i"."_$k"]));
                }else{
                    $big->appendChild($smelem = $dom->createElement("d$k", $xml->xpath("/content/topics/d$i/d$k")[0]));
                    $smelem->appendChild($dom->createElement("type", 'img'));
                    $smelem->appendChild($dom->createElement("desc", $xml->xpath("/content/topics/d$i/d$k/desc")[0]));
                    $smelem->appendChild($dom->createElement('alt', $xml->xpath("/content/topics/d$i/d$k/alt")[0]));
                }
            }
        }

        $content->appendChild($references = $dom->createElement('references'));
        for ($i = 1; $request["ref$i"] != null; $i++){
            $references->appendChild($elem = $dom->createElement("d$i", $request["reft$i"]));
            $elem->appendChild($dom->createElement("href", $request["ref$i"]));
        }
        $dom->save("../public/wiki_data/$wiki->id/$wiki->Version.xml");

        return redirect("/wiki/$wiki->id/v$wiki->Version");
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
