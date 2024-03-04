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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')           ->unique(); 
            $table->string('first_name')                    ->nullable();
            $table->string('last_name')                     ->nullable();
            $table->date('dob')                             ->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('religion',['Islam','Hinduism','Christianity','Other'])->nullable();
            $table->enum('blood_group',['A+','A-','B+','B-','O+','O-','AB+','AB-'])->nullable();
            $table->string('nationality')                    ->nullable();
            $table->string('nid')                            ->nullable();
            $table->softDeletes()->cascadeOnDelete();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
