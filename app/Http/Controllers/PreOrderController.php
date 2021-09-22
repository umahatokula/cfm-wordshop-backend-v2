<?php

namespace App\Http\Controllers;

use App\Models\PreOrder;
use App\Models\PreOrderType;
use Illuminate\Http\Request;

class PreOrderController extends Controller
{

    public function listOrders() {
        $data['preorders'] = PreOrder::all();

        return view('preorders.list', $data);
    }

    public function details(PreOrderType $preOrderType) {
        // dd($preOrderType);
        $data['preOrderType'] = $preOrderType->load('preorders');
        return view('preorders.details', $data);
    }
}
