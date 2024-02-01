<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScorecardHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorecard_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('team_id');
            $table->foreignId('scorecard_id');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('note')->nullable();
            $table->boolean('completed')->default(0)->comment('not started - 0 , completed - 1, in-progress - 2 ');
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('scorecard_histories');
    }
}
