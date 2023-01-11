<?php

namespace App\Observers;

use App\EmployeeDetails;
use App\EmployeeLeaveQuota;
use App\LeaveType;
use App\UniversalSearch;
use DateTime;

class EmployeeDetailObserver
{

    public function saving(EmployeeDetails $detail)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $detail->company_id = company()->id;
        }
    }

    public function created(EmployeeDetails  $detail)
    {
        $leaveTypes = LeaveType::where('company_id', $detail->company_id)->get();
        
        $datetime = new DateTime($detail->joining_date);
        $month = intval($datetime->format('m'));
        $arrLeave = ['1'=>'12','2'=>'11','3'=>'10','4'=>'9','5'=>'8','6'=>'7','7'=>'6','8'=>'5','9'=>'4','10'=>'3','11'=>'2','12'=>'1'];

        foreach ($leaveTypes as $key => $value) {
            EmployeeLeaveQuota::create(
                [
                    'company_id' => $detail->company_id,
                    'user_id' => $detail->user_id,
                    'leave_type_id' => $value->id,
                    'no_of_leaves' => (array_key_exists($month,$arrLeave)) ? $arrLeave[$month] : $value->no_of_leaves
                ]
            );
        }
        session()->forget('company_setting');
        session()->forget('company');
    }

    public function deleting(EmployeeDetails $detail)
    {
        $universalSearches = UniversalSearch::where('searchable_id', $detail->user_id)->where('module_type', 'employee')->get();
        if ($universalSearches){
            foreach ($universalSearches as $universalSearch){
                UniversalSearch::destroy($universalSearch->id);
            }
        }
    }

}
