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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            // user id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // check in time
            $table->timestamp('check_in')->nullable();
            // check out time
            $table->timestamp('check_out')->nullable();
            // status [present, late, absent] enum
            $table->enum('status', ['present', 'late', 'absent'])->default('present');
            // latitude
            $table->string('latitude')->nullable();
            // longitude
            $table->string('longitude')->nullable();
            // note
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
