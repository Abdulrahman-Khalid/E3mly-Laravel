<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('name');
            $table->string('gender', 6);
            $table->date('birthdate');
            $table->string('country');
            $table->string('bio', 300)->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('CV_file')->nullable();
            $table->integer('num_finished_projects')->default(0)->unsigned();
            $table->float('rating')->default(0)->unsigned();
            $table->integer('points')->default(0)->unsigned();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
