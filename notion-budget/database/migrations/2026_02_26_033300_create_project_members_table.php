<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('project_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->index('project_members_project_id');
            $table->string('user_email')->index('project_members_user_email');
            $table->enum('role', ['editor', 'viewer'])->default('viewer');
            $table->timestamp('added_at')->nullable()->useCurrent();

            // A user can only be added once per project
            $table->unique(['project_id', 'user_email'], 'project_members_unique');
        });

        // Foreign keys added separately (matching project pattern)
        Schema::table('project_members', function (Blueprint $table) {
            $table->foreign(['project_id'], 'project_members_ibfk_1')
                ->references(['id'])->on('projects')
                ->onUpdate('no action')->onDelete('cascade');

            $table->foreign(['user_email'], 'project_members_ibfk_2')
                ->references(['email'])->on('user')   // table is 'user' not 'users'
                ->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_members');
    }
};
