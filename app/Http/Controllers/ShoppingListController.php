<?php

namespace App\Http\Controllers;

use App\Models\ShoppingListItem;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        $items = ShoppingListItem::orderBy('created_at', 'desc')->get();

        return view('shopping-list', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        ShoppingListItem::create($data);

        return redirect()->route('shopping-list.index')->with('success', 'Item added.');
    }

    public function destroy(ShoppingListItem $item)
    {
        $item->delete();

        return redirect()->route('shopping-list.index')->with('success', 'Item deleted.');
    }
}
