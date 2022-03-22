<?php
/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 4/30/2017
 * Time: 10:58 AM
 */

namespace App\Http\Controllers\Api;


use App\Models\Bundle;
use App\Models\Product;
use App\Models\Cart as CartModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{    
    /**
     * index
     *
     * @return void
     */
    public function index() {
        
        $items = Cart::content();
        $message = ($items->empty() ? 'Cart is empty' : 'Cart get items success');

        return response(array(
            'success' => $items->empty() ? false : true,
            'data' => $items,
            'message' => $message
        ), 200, []);
    }
    
    /**
     * add
     *
     * @return void
     */
    public function addToCart() {

        // for product
        if (request()->has('product_id')) {
            $product = Product::findOrFail(request('product_id'));
        }

        // for bundle
        if (request()->has('bundle_id')) {
            $bundle = Bundle::findOrFail(request('bundle_id'));
        }
        

        $id    = request()->has('product_id') ? $product->id : $bundle->id;
        $name  = request()->has('product_id') ? $product->name : $bundle->name;
        $price = request('price');
        $qty   = request('qty');

        $item = Cart::add([
            'id' => $id, 
            'name' => $name, 
            'qty' => $qty , 
            'price' => $price,
            'weight' => 0,
            'options' => [
                'is_product' => (request()->has('product_id') ? 1 : 0),
                'is_bundle' => (request()->has('bundle_id') ? 1 : 0),
                'bundle_products' => (request()->has('bundle_id') ? $bundle->products : null),
            ]
        ]);

        if (CartModel::isExisting()) {
            $userId = auth()->id();
            Cart::store($userId);
        }

        return response(array(
            'success' => true,
            'data' => $item,
            'message' => "Item added."
        ), 201, []);
    }
    
    /**
     * updateCart
     *
     * @param  mixed $request
     * @return void
     */
    public function updateCartItem(Request $request) {

        \Cart::update(
            $request->id,
            [
                'qty' => [
                    'relative' => false,
                    'value' => $request->qty
                ],
            ]
        );

        return response(array(
            'success' => true,
            'message' => "Item updated"
        ),201,[]);
    }
    
    /**
     * removeCart
     *
     * @param  mixed $request
     * @return void
     */
    public function removeCartItem($rowId) {

        Cart::remove($rowId);

        return response(array(
            'success' => true,
            'message' => "Item removed"
        ), 201, []);
    }
    
    /**
     * clearAllCart
     *
     * @return void
     */
    public function clearCart() {

        Cart::destroy();

        return response(array(
            'success' => true,
            'message' => "Cart cleared"
        ),201,[]);
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id) {
        $userId = auth()->id(); // get this from session or wherever it came from

        \Cart::session($userId)->remove($id);

        return response(array(
            'success' => true,
            'data' => $id,
            'message' => "cart item {$id} removed."
        ),200,[]);
    }
    
    /**
     * details
     *
     * @return void
     */
    public function getCartItem() {
        
        $rowId = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';

        Cart::get($rowId);

        return response(array(
            'success' => true,
            'data' => array(
                'total_quantity' => \Cart::session($userId)->getTotalQuantity(),
                'sub_total' => \Cart::session($userId)->getSubTotal(),
                'total' => \Cart::session($userId)->getTotal(),
                'cart_sub_total_conditions_count' => $subTotalConditions->count(),
                'cart_total_conditions_count' => $totalConditions->count(),
            ),
            'message' => "Get cart details success."
        ),200,[]);
    }
    
    /**
     * details
     *
     * @return void
     */
    public function cartSummary() {

        return response(array(
            'success' => true,
            'data' => array(
                'total_quantity' => Cart::count(),
                'sub_total' => Cart::subtotal(),
                'total' => Cart::total(),
                'total_tax' => Cart::tax(),
                'total_discount' => Cart::discount(),
                'total_before_discount_and_taxes' => Cart::priceTotal(),
            ),
            'message' => "Get cart details success."
        ), 200, []);
    }

}