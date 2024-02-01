<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScorecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scorecards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->unsignedBigInteger('team_id');
            $table->string('timer',60)->nullbale();
            $table->string('title')->nullbale();
            $table->text('description')->nullbale();
            $table->mediumText('kpi_metric')->nullbale();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('next_due_date')->nullable();
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
        Schema::dropIfExists('scorecards');
    }
}
