<?php

namespace Tests\Feature\Orders;

use App\Models\Article;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_see_orders_index()
    {
        Order::factory($this->faker()->numberBetween(2, 10))->create();

        $response = $this->get(route('orders.index'));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function can_create_order_from_articles()
    {
        $articles = Article::factory($this->faker()->numberBetween(2, 10))->make();

        $data = $articles->map(fn (Article $article) => [
            'ArticleCode' => $article->code,
            'ArticleName' => $article->name,
            'UnitPrice' => $article->unit_price,
            'Quantity' => $article->quantity,
        ]);

        $response = $this->postJson(route('orders.store'), ['articles' => $data->toArray()]);

        $response->assertStatus(200);

        $this->assertDatabaseCount('orders', 1);
    }

    /**
     * @test
     */
    public function can_calculate_prices_properly_when_creating_orders()
    {
        $articles = Article::factory($this->faker()->numberBetween(2, 10))->make();

        $data = $articles->map(fn (Article $article) => [
            'ArticleCode' => $article->code,
            'ArticleName' => $article->name,
            'UnitPrice' => $article->unit_price,
            'Quantity' => $article->quantity,
        ]);

        $expectedTotal = $articles->map(
            fn (Article $article) => $article->setTotalPrice()->total_price
        )->sum();
        $expectedTotalWithDiscount = $articles->map(
            fn (Article $article) => $article->setTotalPrice()->total_price_with_discount
        )->sum();

        $response = $this->postJson(route('orders.store'), ['articles' => $data->toArray()]);

        $response->assertStatus(200)
            ->assertJsonPath('total', round($expectedTotal, 2))
            ->assertJsonPath('total_with_discount', round($expectedTotalWithDiscount, 2));

        $this->assertDatabaseCount('orders', 1);
    }
}
