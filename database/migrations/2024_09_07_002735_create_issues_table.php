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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignIdFor(\App\Models\Project::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\IssueType::class, 'type_id')->constrained('issue_types')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\IssueStatus::class, 'status_id')->constrained('issue_statuses')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Priority::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Epic::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'assignee_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class, 'reporter_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('due_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
