<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('objective_id');
            $table->unsignedBigInteger('owner_id');
            // $table->foreign('objective_id')->references('id')->on('objectives')->onDelete('cascade');
            $table->integer('team_id')->nullable();
            $table->unsignedBigInteger('assign_user_id');
            $table->string('content')->nullable();
            $table->integer('position')->default(0);
            $table->boolean('completed')->default(0);
            $table->boolean('is_team_objctive')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('key_results');
    }
}
