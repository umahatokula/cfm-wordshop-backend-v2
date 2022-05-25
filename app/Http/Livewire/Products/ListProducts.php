<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ListProducts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.products.list-products', [
            'products' => Product::where('name', 'like', '%'.$this->search.'%')->with('categories', 'preacher')->orderBy('date_preached', 'desc')->paginate(20)
        ]);
    }

    public function delete(Product $product) {
        $product->delete();
    }
}
