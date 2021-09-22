<?php

namespace App\Models;

use App\Models\PreOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PreOrderType extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sermons' => 'array',
    ];

    public function preorders() {
        return $this->hasMany(PreOrder::class);
    }
}
