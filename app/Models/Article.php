<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $code
 * @property string $name
 * @property float $unit_price
 * @property int $quantity
 */
class Article extends Model
{
    use HasFactory;
}
