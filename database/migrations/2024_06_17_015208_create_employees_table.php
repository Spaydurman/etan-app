<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('position');
            $table->string('job_type');
            $table->date('hired_date');
            $table->date('start_date');
            $table->string('supervisor');
            $table->float('daily_rate');
            $table->float('cash_advance');
            $table->date('birthdate');
            $table->string('nationality');
            $table->string('gender');
            $table->string('contact_number')->unique();
            $table->string('email')->unique();
            $table->string('address');
            $table->string('image')->nullable();
            $table->string('file_upload')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
