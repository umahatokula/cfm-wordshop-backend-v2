<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Product;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class SearchController extends Controller
{
    public function searcher($query, $perPage = 15) {

        $results = [];

        if (!is_null($query)) {
            $results = Search::new()
                ->add(Product::class, ['name', 'description'])
                ->add(Bundle::with('products'), ['name', 'description'])
                ->includeModelType()
                ->paginate((int)$perPage, $pageName = 'page', $page = 1)
                ->search('"'.$query.'"');
        }

        return response()->json([
            'status' => true,
            'data' => $results,
        ], 200);

    }
}
