<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['entry', 'exit']);
            $table->foreignId('category_id')->constrained();
            $table->decimal('quantity', 8, 2);
            $table->decimal('value', 10, 2);
            $table->date('date');
            $table->text('description')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movements');
    }
};