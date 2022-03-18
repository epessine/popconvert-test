<?php

namespace App\Models;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $code
 * @property float $total
 * @property float $total_with_discount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'total',
        'total_with_discount'
    ];

    protected static function booted()
    {
        static::updated(function (Order $order) {
            Http::fake(function (Request $request) {
                return Http::response(
                    "Data received on {$request->url()}: " . json_encode($request->data()),
                    200
                );
            });

            if (!$order->code) {
                return;
            }

            $data = [
                'OrderId' => $order->id,
                'OrderCode' => $order->code,
                'OrderDate' => $order->created_at->format('Y-m-d'),
                'TotalAmountWihtoutDiscount' => $order->total,
                'TotalAmountWithDiscount' => $order->total_with_discount,
            ];
            $response = Http::post('https://localhost:9001/order', $data);
            Log::info($response);

            $data = [
                'id' => $order->id,
                'code' => $order->code,
                'date' => $order->created_at->format('Y-m-d'),
                'total' => $order->total,
                'discount' => $order->total - $order->total_with_discount,
            ];
            $response = Http::post('https://localhost:9002/v1/order', $data);
            Log::info($response);

            $data = [
                'id' => $order->id,
                'code' => $order->code,
                'date' => $order->created_at->format('Y-m-d'),
                'totalAmount' => $order->total,
                'totalAmountWithDiscount' => $order->total_with_discount,
            ];
            $response = Http::post('https://localhost:9003/web_api/order', $data);
            Log::info($response);
        });
    }
}
