<?php

namespace App\Http\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
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
        return view('livewire.orders.index', [
            'orders' => Order::where('order_number', 'like', '%'.$this->search.'%')->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}
