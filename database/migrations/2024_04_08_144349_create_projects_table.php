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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamp('deadline');
            // $table->foreignIdFor(\App\Models\User::class,'assigned_user')->constrained();
            // $table->foreignIdFor(\App\Models\Client::class,'assigned_client')->constrained();
            $table->foreignIdFor(\App\Models\User::class,'assigned_user');
            $table->foreignIdFor(\App\Models\Client::class,'assigned_client');
            $table->string('status')->default('open');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
