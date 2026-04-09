<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shopping_list_items', function (Blueprint $table) {
            // Add category after is_completed (if present) or after notes as a fallback
            if (Schema::hasColumn('shopping_list_items', 'is_completed')) {
                $table->string('category')->default('Other')->after('is_completed');
            } else {
                $table->string('category')->default('Other')->after('notes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shopping_list_items', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
