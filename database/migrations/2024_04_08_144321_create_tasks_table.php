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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class,'user_id')->constrained();
            $table->foreignIdFor(App\Models\Client::class,'client_id')->constrained();
            $table->foreignIdFor(App\Models\Project::class,'project_id')->constrained();
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamp('deadline');
            $table->timestamp('finished_at')->nullable();
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
        Schema::dropIfExists('tasks');
    }
};
