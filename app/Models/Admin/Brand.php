<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo',
    ];
//     public function products(){
//         return $this->hasMany(Product::class, 'brand_id', 'id');
//     }
public function products(){
    return $this->hasMany(Product::class,'brand_id','id');
}
}
