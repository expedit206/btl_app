<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  class CreateTasksTable extends Migration
  {
      public function up()
      {
          Schema::create('tasks', function (Blueprint $table) {
              $table->id();
              $table->foreignId('user_id')->constrained()->onDelete('cascade');
              $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
              $table->string('title');
              $table->text('description')->nullable();
              $table->enum('priority', ['low', 'medium', 'high']);
              $table->date('due_date')->nullable();
              $table->boolean('status')->default(false);
              $table->timestamps();
          });
      }

      public function down()
      {
          Schema::dropIfExists('tasks');
      }
  }