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
        Schema::create('issue_sprint', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Issue::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Sprint::class)->constrained()->cascadeOnDelete();
            $table->unique(['issue_id', 'sprint_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_sprint');
    }
};
