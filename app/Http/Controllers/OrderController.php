<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $articles = Article::factory(10)->make();

        return view('orders.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $rawArticles = $request->validate([
            'articles' => 'required|array|min:1',
            'articles.*' => 'required|array:ArticleCode,ArticleName,UnitPrice,Quantity',
        ]);

        $articles = collect();

        collect($rawArticles)->each(
            function ($rawArticle) use (&$articles) {
                $article = Article::factory()->make([
                    'code'       => data_get($rawArticle, 'ArticleCode'),
                    'name'       => data_get($rawArticle, 'ArticleName'),
                    'unit_price' => data_get($rawArticle, 'UnitPrice'),
                    'quantity'   => data_get($rawArticle, 'Quantity'),
                ]);

                $articles->each(function (&$existingArticle) use (&$article, &$articles) {
                    if ($existingArticle->code === $article->code) {
                        $existingArticle->quantity++;
                    } else {
                        $articles->add($article);
                    }
                });
            }
        );
    }
}
