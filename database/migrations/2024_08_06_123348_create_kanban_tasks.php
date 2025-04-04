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
        Schema::create('kanban_actions', function (Blueprint $table) {
            $table->id();
            $table->string('action_id')->comment('id from actions');
            $table->longtext('description')->nullable();
            $table->date('due_date')->nullable();
            $table->string('stage_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kanban_actions');
    }
};
