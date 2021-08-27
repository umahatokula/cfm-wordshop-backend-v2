<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleProduct extends Model
{
    protected $table = 'bundle_product';

    protected $fillable = ['bundle_id', 'product_id'];
}
