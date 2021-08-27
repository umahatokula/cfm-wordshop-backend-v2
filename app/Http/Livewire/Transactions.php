<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;

class Transactions extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showOrder($orderNumber) {

    }

    public function showPinDetails() {

    }

    public function render()
    {
        return view('livewire.transactions', [
            'transactions' => Transaction::where('transaction', 'like', '%'.$this->search.'%')->with('pin')->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}
