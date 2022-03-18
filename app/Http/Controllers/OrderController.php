<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Article;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $articles = Article::factory(Factory::create()->numberBetween(2, 8))->make();

        return view('orders.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $rawArticles = $request->validate([
            'articles' => 'required|array|min:1',
            'articles.*' => 'required|array',
            'articles.*.ArticleCode' => 'required|string',
            'articles.*.ArticleName' => 'required|string',
            'articles.*.UnitPrice' => 'required|numeric',
            'articles.*.Quantity' => 'required|integer',
        ]);

        $articles = collect();

        collect($rawArticles['articles'])->each(
            function ($rawArticle) use (&$articles) {
                $article = Article::factory()->make([
                    'code'       => data_get($rawArticle, 'ArticleCode'),
                    'name'       => data_get($rawArticle, 'ArticleName'),
                    'unit_price' => data_get($rawArticle, 'UnitPrice'),
                    'quantity'   => data_get($rawArticle, 'Quantity'),
                ]);

                $isNew = true;

                $articles->each(function (Article &$existingArticle) use (&$article, &$isNew) {
                    if ($existingArticle->code === $article->code) {
                        $isNew = false;
                        $existingArticle->quantity++;
                        $existingArticle->setTotalPrice();
                    }
                });

                if ($articles->isEmpty() || $isNew) {
                    $article->setTotalPrice();
                    $articles->push($article);
                }
            }
        );

        DB::beginTransaction();

        try {
            $order = Order::factory()->create([
                'code' => null,
                'total' => null,
                'total_with_discount' => null,
            ]);

            $order->update([
                'code' => "{$order->created_at->format('Y-m')}-OrderId",
                'total' => round($articles->sum(fn (Article $article) => $article->total_price), 2),
                'total_with_discount' => round($articles->sum(
                    fn (Article $article) => $article->total_price_with_discount
                ), 2),
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response('Error saving order:' . $th->getMessage(), 500);
        }

        DB::commit();

        return response()->json($order);
    }
}
