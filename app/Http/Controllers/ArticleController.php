<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use App\Tag;
use App\User;
use App\Events\ArticleCommentCreated;

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
            $tags = array_unique(array_map('trim', explode(',', $request->input('tags'))));
            foreach ($tags as $tag) {
                $t = Tag::firstOrCreate(['tag'=>$tag]);
                $article->tags()->attach($t);
            }
        }

        $request->session()->flash('success_message', 'Yeni makaleniz başarıyla eklendi.');

        return redirect()->route('articles.detail', $article);
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
            $tags = array_unique(array_map('trim', explode(',', $request->input('tags'))));
            foreach ($tags as $tag) {
                $t = Tag::firstOrCreate(['tag'=>$tag]);
                $tagsToSync[]=$t->id;
            }
        }
        $article->tags()->sync($tagsToSync);

        $request->session()->flash('success_message', 'Makale başarıyla güncellendi.');

        return redirect()->route('articles.detail', $article->id);
    }

    public function addComment(Article $article, Request $request)
    {
        $request->validate([
            'comment' => 'required|string|min:5',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = new Comment;
        $comment->article_id = $article->id;
        $comment->user_id = $request->user()->id;
        $comment->body = $request->input('comment');
        if($request->input('parent_id')) $comment->parent_id = $request->input('parent_id');
        $comment->save();
        $request->session()->flash('success_message', 'Yorumunuz başarıyla eklendi.');
        event(new ArticleCommentCreated($article, $comment));
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
