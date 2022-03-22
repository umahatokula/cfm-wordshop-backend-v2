<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PreOrderType;
use Illuminate\Http\Request;
use App\Mail\PreOrderedLinks;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\PreOrderTypesController;

class PreOrderTypesController extends Controller
{
    public function index() {
        $data['preorders'] = PreOrderType::all();

        return view('preorders-type.index', $data);
    }

    public function create() {
        $data['sermons'] = Product::pluck('name', 'id');
        
        return view('preorders-type.create', $data);
    }

    public function store(Request $request) {
        // dd($request->all());

    	$rules = [
    	'name' => 'required',
    	'sermons' => 'required',
    	];

        $this->validate($request, $rules);

        $preOrderType = new PreOrderType;
        $preOrderType->name = $request->name;
        $preOrderType->sermons = json_encode($request->sermons);
        $preOrderType->save();
        
        return redirect()->route('pre-order-type.index');

    }

        
    /**
     * send sermon Links to emails on preorder list
     *
     * @return void
     */
    public function sendLinks(PreOrderType $preOrderType) {

        $preorderedSermons = json_decode($preOrderType->sermons);
        $sermons = Product::whereIn('id', $preorderedSermons)->get();

        $modified = collect($sermons)->map(function ($sermon, $key) {
            $sermon->temp_link = $sermon->getTempDownloadUrl(7);
            return $sermon;
        });
        
        // Mail::to($preOrderType->preorders)->send(new PreOrderedLinks($sermons->load('preacher')));

        Mail::to('media@christfamilyministries.org')
            ->bcc($preOrderType->preorders)
            ->send(new PreOrderedLinks($sermons->load('preacher')));

        return redirect()->route('pre-order-type.index');
    }
}
