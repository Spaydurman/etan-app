<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->decimal('sunday', 15, 2)->nullable();
            $table->decimal('sunday_ot', 15, 2)->nullable();
            $table->decimal('monday', 15, 2)->nullable();
            $table->decimal('monday_ot', 15, 2)->nullable();
            $table->decimal('tuesday', 15, 2)->nullable();
            $table->decimal('tuesday_ot', 15, 2)->nullable();
            $table->decimal('wednesday', 15, 2)->nullable();
            $table->decimal('wednesday_ot', 15, 2)->nullable();
            $table->decimal('thursday', 15, 2)->nullable();
            $table->decimal('thursday_ot', 15, 2)->nullable();
            $table->decimal('friday', 15, 2)->nullable();
            $table->decimal('friday_ot', 15, 2)->nullable();
            $table->decimal('saturday', 15, 2)->nullable();
            $table->decimal('saturday_ot', 15, 2)->nullable();
            $table->decimal('cash_advance', 15, 2)->nullable();
            $table->decimal('sss', 15, 2)->nullable();
            $table->decimal('phil_health', 15, 2)->nullable();
            $table->decimal('tax', 15, 2)->nullable();
            $table->decimal('meals', 15, 2)->nullable();
            $table->decimal('others', 15, 2)->nullable();
            $table->date('from');
            $table->date('to');
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
        Schema::dropIfExists('salary');
    }
}
