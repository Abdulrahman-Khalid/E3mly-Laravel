<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->mediumtext('body');
            $table->integer('cost');
            $table->string('description_file')->nullable();
            $table->date('suppose_to_finish');
            $table->date('finish_date')->nullable();
            $table->date('rating')->nullable();
            $table->integer('status')->default(0);
            $table->unsignedInteger('craftman_id');
            $table->foreign('craftman_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('category');                        
            $table->timestamp('created_at')->nullable();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
