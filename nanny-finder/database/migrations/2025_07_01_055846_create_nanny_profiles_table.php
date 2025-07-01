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
        Schema::create('nanny_profiles', function (Blueprint $table) {
            $table->id('nanny_profiles_id');
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->integer('experience_years');
            $table->integer('age');
            $table->decimal('hourly_rate', 8, 2);
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nanny_profiles');
    }
};
