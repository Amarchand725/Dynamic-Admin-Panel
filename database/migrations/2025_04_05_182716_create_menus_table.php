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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by')->nullable();
            $table->string('icon')->nullable();
            $table->string('menu_group')->nullable();
            $table->string('menu')->nullable();
            $table->string('menu_label')->nullable();
            $table->integer('group_order')->nullable(); // for sorting groups
            $table->integer('menu_order')->nullable();  // for sorting inside group
            $table->integer('priority')->nullable();
            $table->text('fields')->nullable(); 
            $table->boolean('status')->default(1);
            $table->string('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
