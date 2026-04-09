<?php

namespace App\Http\Controllers;

use App\Models\ShoppingListItem;
use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all'); // all | active | completed
        $category = $request->query('category');

        $query = ShoppingListItem::query();

        // Category filter
        if (!empty($category) && $category !== 'All') {
            $query->where('category', $category);
        }

        // Status filter
        if ($status === 'active') {
            $query->where('is_completed', false);
        } elseif ($status === 'completed') {
            $query->where('is_completed', true);
        }

        $items = $query->orderBy('created_at', 'desc')->get();

        $categories = ShoppingListItem::CATEGORIES;

        return view('shopping-list', compact('items', 'categories', 'category', 'status'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
            'category' => 'required|string|in:Fruit & Veg,Dairy,Frozen,Bakery,Household,Other',
        ]);

        // Ensure category falls back to Other if somehow missing
        if (empty($data['category'])) {
            $data['category'] = 'Other';
        }

        ShoppingListItem::create($data);

        return redirect()->route('shopping-list.index')->with('success', 'Item added.');
    }

    public function update(Request $request, ShoppingListItem $item)
    {
        $data = $request->validate([
            'is_completed' => 'required|boolean',
        ]);

        $item->update(['is_completed' => $data['is_completed']]);

        return redirect()->route('shopping-list.index')->with('success', 'Item updated.');
    }

    public function destroy(ShoppingListItem $item)
    {
        $item->delete();

        return redirect()->route('shopping-list.index')->with('success', 'Item deleted.');
    }
}
