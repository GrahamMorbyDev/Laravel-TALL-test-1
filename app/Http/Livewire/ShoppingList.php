<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ShoppingListItem;

class ShoppingList extends Component
{
    public $name = '';
    public $quantity = 1;
    public $notes = '';
    public $items = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'notes' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->loadItems();
    }

    public function loadItems()
    {
        $this->items = ShoppingListItem::orderBy('created_at', 'desc')->get();
    }

    public function addItem()
    {
        $this->validate();

        ShoppingListItem::create([
            'name' => $this->name,
            'quantity' => $this->quantity,
            'notes' => $this->notes ?: null,
        ]);

        $this->reset(['name', 'quantity', 'notes']);
        $this->quantity = 1;
        $this->loadItems();
        $this->emit('itemAdded');
    }

    public function deleteItem($id)
    {
        $item = ShoppingListItem::find($id);
        if ($item) {
            $item->delete();
            $this->loadItems();
            $this->emit('itemDeleted');
        }
    }

    public function render()
    {
        return view('livewire.shopping-list');
    }
}
