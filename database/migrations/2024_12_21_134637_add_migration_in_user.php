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
        Schema::table('users', function (Blueprint $table) {
            // employee id
            $table->string('employee_id')->nullable();
            // employee job title
            $table->string('job_title')->nullable();
            // role [admin, user] enum
            $table->enum('role', ['admin', 'user'])->default('user');
            // image
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Users', function (Blueprint $table) {
            //
        });
    }
};
