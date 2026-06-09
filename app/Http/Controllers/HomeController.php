<?php

namespace App\Http\Controllers;

use App\Models\Article;

class HomeController extends Controller
{
    public function index()
    {
        $query = Article::orderBy('published_at', 'desc');

        if (request('source')) {
            $query->where('source', request('source'));
        }

        $articles = $query->paginate(9)->withQueryString();

        $sources = Article::select('source')
            ->distinct()
            ->pluck('source');

        $hero = $articles->first();
        $side = $articles->slice(1, 2);
        $grid = $articles->slice(3);

        return view(
            'home',
            compact('articles', 'sources', 'hero', 'side', 'grid')
        );
    }
}