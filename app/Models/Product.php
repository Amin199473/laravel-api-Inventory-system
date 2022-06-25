<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id', 'product_name', 'product_code', 'root', 'buying_price', 'selling_price', 'supplier_id', 'buying_date', 'image', 'product_quantity'
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class);
    }
}
