<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Notifications\NewProduct;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'price',
        'seller'

    ];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (Product $product) {
            $delay = now()->addMinute();
            $users = User::all();
            foreach ($users as $user) {
                $user->notify((new NewProduct($product))->delay($delay));
            }
        });
    }
}
