<?php

use Illuminate\Database\Seeder;
use App\EmployeeDetails;
use App\EmployeeLeaveQuota;
use App\LeaveType;

class new_employee_leave_quotasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = \App\Company::all();

        if ($companies) {
            foreach ($companies as $company) {
             
                $leaveTypes = LeaveType::where('company_id', $company->id)->get();
                $employees = EmployeeDetails::where('company_id', $company->id)->get();

                foreach ($employees as $key => $employee) {

                    $date= $employee->joining_date->format('m') ;
                    $month= DB::table('month_leves')->where('no',$date)->first();
                 
            // echo '<pre>';print_r($month->id);die;
                    //   $date= $employee->employee->format('M') ;
                     //  echo $date;die;
                     if(isset($month->id)){
                        DB::table('new_employee_leave_quotas')->insert(
                            [
                                'company_id' => $company->id,
                                'user_id' => $employee->user_id,
                                'month_leves_id' => $month->id,
                               'sl' => $month->sl,
                               'cl' => $month->cl,
                               'join_date' => $employee->joining_date,
                            ]
                        );
                    }
                  
                }
            }
        }
    }
}
