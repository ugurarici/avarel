<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Weather;
use App\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $userIdsToShowArticles = $request->user()->followees()->pluck('id')->toArray();
        $userIdsToShowArticles[] = $request->user()->id;
        $articles = Article::whereIn('user_id', $userIdsToShowArticles)->latest()->get();
        return view('home', compact('articles'));
    }

    // public function showWeather(Weather $weatherService)
    // {
    //     return $weatherService->getWeather('Bolu', 'metric', 'tr')->temperature;
    // }

    public function feed(Request $request)
    {
        $userIdsToShowArticles = $request->user()->followees()->pluck('id')->toArray();
        $userIdsToShowArticles[] = $request->user()->id;
        $articles = Article::whereIn('user_id', $userIdsToShowArticles)->latest()->get();
        return view('feed', compact('articles'));
    }
}
