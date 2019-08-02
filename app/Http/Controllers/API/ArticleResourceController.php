<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Article;
use App\Comment;
use App\Tag;
use App\User;
use App\Events\ArticleCommentCreated;
use Gate;

class ArticleResourceController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Article::latest()->paginate(10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return array(
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:5',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:3000'
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(array(
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:5',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|max:3000'
        ));

        $article = new Article;
        $article->user_id = $request->user()->id;
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $article->image = $path;
        }
        $article->save();

        if($request->input('tags')) {
            $tags = array_unique(array_map('trim', explode(',', $request->input('tags'))));
            foreach ($tags as $tag) {
                $t = Tag::firstOrCreate(['tag'=>$tag]);
                $article->tags()->attach($t);
            }
        }

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return array(
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:5',
            'tags' => 'comma seperated string values'
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        if ($request->user()->cant('update', $article)) 
            return abort(403, "Bu makaleyi güncelleme yetkiniz bulunmuyor.");

        $request->validate(array(
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:5'
        ));

        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->save();

        $tagsToSync=[];
        if($request->input('tags')) {
            $tags = array_unique(array_map('trim', explode(',', $request->input('tags'))));
            foreach ($tags as $tag) {
                $t = Tag::firstOrCreate(['tag'=>$tag]);
                $tagsToSync[]=$t->id;
            }
        }
        $article->tags()->sync($tagsToSync);

        return response()->json($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Article $article)
    {
        if ($request->user()->cant('delete', $article)) 
            return abort(403, "Bu makaleyi silme yetkiniz bulunmuyor.");

        return ['result' => $article->delete()];
    }
}
