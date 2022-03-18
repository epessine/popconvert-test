<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $code
 * @property string $name
 * @property float $unit_price
 * @property float $total_price
 * @property float $total_price_with_discount
 * @property int $quantity
 */
class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'unit_price',
        'total_price',
        'total_price_with_discount',
    ];

    public function setTotalPrice(): self
    {
        if (!$this->quantity) {
            $this->total_price = $this->total_price_with_discount = 0;
            return $this;
        }

        $this->total_price = $this->unit_price * $this->quantity;

        $hasDiscount = ($this->quantity >= 5 && $this->quantity <= 9)
            && $this->total_price > 500;

        $this->total_price_with_discount = $hasDiscount
            ? $this->total_price * 0.85
            : $this->total_price;

        return $this;
    }
}
