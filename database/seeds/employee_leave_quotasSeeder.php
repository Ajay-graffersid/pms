<?php

use Illuminate\Database\Seeder;
use App\EmployeeDetails;
use App\EmployeeLeaveQuota;
use App\LeaveType;

class employee_leave_quotasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = \App\Company::all();

        $companies = \App\Company::all();

        if ($companies) {
            foreach ($companies as $company) {
                $leaveTypes = LeaveType::where('company_id', $company->id)->get();
                $employees = EmployeeDetails::where('company_id', $company->id)->get();

                foreach ($employees as $key => $employee) {

                    $date= $employee->joining_date->format('m') ;
                    $month= DB::table('month_leves')->where('no',$date)->first();
                    if($month){
                        $no_leave=$month->sl+$month->sl;
                    }else{
                        $no_leave="";
                    }
                   
                    foreach ($leaveTypes as $key => $value) {
                        EmployeeLeaveQuota::create(
                            [
                                'company_id' => $company->id,
                                'user_id' => $employee->user_id,
                                'leave_type_id' => $value->id,
                                //'no_of_leaves' => $value->no_of_leaves
                                'no_of_leaves' => $no_leave
                            ]
                        );
                    }
                }
            }
        }
    }
}
