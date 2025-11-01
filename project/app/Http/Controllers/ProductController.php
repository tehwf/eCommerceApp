<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    //
    public function index()
    {
        $items = Item::all();
        return Inertia::render('Product', [
            'items' => $items
        ]);
    }

    public function show($id)
    {
        $item = Item::find($id);

        if (!$item) {
            abort(404, 'Item not found');
        }

        return Inertia::render('Catalogue', [
            'item' => $item,
        ]);
    }
}
