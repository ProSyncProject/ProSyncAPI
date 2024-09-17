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
        Schema::create('identifiers', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->foreignIdFor(\App\Models\Project::class)->constrained()->cascadeOnDelete();
            $table->morphs('identifiable');
            $table->integer('issue_number');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identifiers');
    }
};
