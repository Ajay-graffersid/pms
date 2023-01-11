<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\EmployeeDetails;
use App\EmployeeLeaveQuota;
use App\LeaveType;

class CreateNewEmployeeLeaveQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_employee_leave_quotas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('month_leves_id');
         //   $table->foreign('month_leves_id')->references('id')->on('month_leves')->onDelete('cascade')->onUpdate('cascade');
            $table->string('join_date');
            $table->string('sl');
            $table->string('cl');

            $table->string('no_of_leaves');
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
        Schema::dropIfExists('new_employee_leave_quotas');
    }
}
