<?php
/**
 * Created by PhpStorm.
 * User: darryldecode
 * Date: 1/13/2018
 * Time: 1:25 PM
 */

namespace App\Models;


use Darryldecode\Cart\CartCollection;

class DatabaseStorage
{    
    /**
     * has
     *
     * @param  mixed $key
     * @return void
     */
    public function has($key)
    {
        return DatabaseStorageModel::find($key);
    }
    
    /**
     * get
     *
     * @param  mixed $key
     * @return void
     */
    public function get($key)
    {
        if($this->has($key))
        {
            return new CartCollection(DatabaseStorageModel::find($key)->cart_data);
        }
        else
        {
            return [];
        }
    }
        
    /**
     * put
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function put($key, $value)
    {
        if($row = DatabaseStorageModel::find($key))
        {
            // update
            $row->cart_data = $value;
            $row->save();
        }
        else
        {
            DatabaseStorageModel::create([
                'id' => $key,
                'cart_data' => $value
            ]);
        }
    }
}