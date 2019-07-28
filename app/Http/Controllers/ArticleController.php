<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use App\Tag;
use App\User;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

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
            $tags = explode(',', $request->input('tags'));
            foreach ($tags as $tag) {
                $t = Tag::firstOrCreate(['tag'=>$tag]);
                $article->tags()->attach($t);
            }
        }

        return redirect()->route('articles.detail', $article->id);
    }

    public function detail(Article $article)
    {
        return view('articles.detail', compact('article'));
    }

    public function edit(Article $article, Request $request)
    {
        if($request->user()->id!==$article->user->id) return redirect()->route('home');
        return view('articles.edit', compact('article'));
    }

    public function update(Article $article, Request $request)
    {
        if($request->user()->id!==$article->user->id) return redirect()->route('home');

        $request->validate(array(
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:5'
        ));

        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->save();

        $tagsToSync=[];
        if($request->input('tags')) {
            $tags = explode(',', $request->input('tags'));
            foreach ($tags as $tag) {
                $t = Tag::firstOrCreate(['tag'=>$tag]);
                $tagsToSync[]=$t->id;
            }
        }
        $article->tags()->sync($tagsToSync);

        return redirect()->route('articles.detail', $article->id);
    }

    public function addComment(Article $article, Request $request)
    {
        $request->validate([
            'comment' => 'required|string|min:5'
        ]);

        $comment = new Comment;
        $comment->article_id = $article->id;
        $comment->user_id = $request->user()->id;
        $comment->body = $request->input('comment');
        if($request->input('parent_id')) $comment->parent_id = $request->input('parent_id');
        $comment->save();
        return redirect()->route('articles.detail', $article);
    }

    public function tagArticles(Tag $tag)
    {
        $articles = $tag->articles()->latest()->get();
        return view('articles.index', compact('articles', 'tag'));
    }

    public function userArticles(User $user)
    {
        $articles = $user->articles()->latest()->get();
        return view('articles.index', compact('articles', 'user'));
    }

}
