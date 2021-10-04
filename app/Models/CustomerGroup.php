<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;
    protected $table = "customer_groups";
    protected $fillable = [
    	'name',
        'description',
    ];

    public function customers(){
    	return $this->hasMany(Customer::class,'customer_group_id','id');
    }
}
