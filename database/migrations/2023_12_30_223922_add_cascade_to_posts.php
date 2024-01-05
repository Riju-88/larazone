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
        Schema::table('posts', function (Blueprint $table) {
            //
            if (Schema::hasColumn('posts', 'category_id')) {
                // Temporarily drop the foreign key constraint
                Schema::table('posts', function (Blueprint $table) {
                    $table->dropForeign(['category_id']);
                });
    
                // Add the foreign key constraint with onDelete('cascade')
                Schema::table('posts', function (Blueprint $table) {
                    $table->foreign('category_id')
                          ->references('id')->on('categories')
                          ->onDelete('cascade');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
                $table->foreign('category_id')
                      ->references('id')->on('categories');
            });
        });
    }
};
