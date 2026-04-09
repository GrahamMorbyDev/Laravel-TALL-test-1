<?php

namespace App\Http\Controllers;

use App\Models\ShoppingListItem;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {
        $items = ShoppingListItem::orderBy('created_at', 'desc')->get();
        return view('shopping.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        ShoppingListItem::create($data);

        return redirect()->back()->with('success', 'Item added to your shopping list.');
    }

    public function destroy(ShoppingListItem $shopping_list_item)
    {
        $shopping_list_item->delete();

        return redirect()->back()->with('success', 'Item removed from your shopping list.');
    }
}
