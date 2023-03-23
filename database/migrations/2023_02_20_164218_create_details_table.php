<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('details', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('user_id')->unsigned();
            $table->string('first_name')->default('user');
            $table->string('last_name')->default('_unKnow');
            $table->dateTime('birth_date')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('github_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->enum('user_type',['teacher','student','admin'])->default('student');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        DB::table('users')->insert([
            'email'=>'admin@admin.com',
            'password'=> bcrypt('admin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('details')->insert([
            'user_id'=>1,
            'user_type'=>'admin'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
