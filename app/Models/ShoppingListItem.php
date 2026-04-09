<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'quantity', 'notes'])]
class ShoppingListItem extends Model
{
    use HasFactory;

    // The attributes that are mass assignable are defined via the Fillable attribute above.
}
