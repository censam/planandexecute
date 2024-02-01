<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObjectivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unsigned();
            $table->foreignId('team_id')->unsigned();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('due_date')->useCurrent();
            $table->text('key_results')->nullable();
            $table->bigInteger('edit_by_user')->nullable();
            $table->string('allowed_users',100)->nullable();
            $table->bigInteger('parent_id')->default(0);
            $table->text('completed_note')->nullable();
            $table->boolean('completed')->default(0)->comment('not started - 0 , completed - 1, in-progress - 2 ');
            $table->boolean('approved')->default(0);
            $table->boolean('objective_type')->default(0);
            $table->boolean('mail_sent')->nullable();
            $table->string('timer',60)->nullable();
            $table->boolean('status')->default(0);
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('objectives');
    }
}
