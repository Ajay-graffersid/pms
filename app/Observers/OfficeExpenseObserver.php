<?php

namespace App\Observers;

use App\Events\NewOfficeExpenseEvent;
use App\OfficeExpense;
use Illuminate\Support\Facades\File;
use App\Notification;

class OfficeExpenseObserver
{

    public function created(OfficeExpense $expense)
    {
        if (!isRunningInConsoleOrSeeding()) {
            // Default status is approved means it is posted by admin
            if ($expense->status == 'approved') {
                $userType = 'admin';
            }

            // Default status is pending that mean it is posted by member
            if ($expense->status == 'pending') {
                $userType = 'member';
            }
            event(new NewOfficeExpenseEvent($expense, $userType));
        }
    }

    public function updated(OfficeExpense $expense)
    {
        if (!isRunningInConsoleOrSeeding()) {
            if ($expense->isDirty('status')) {
                event(new NewOfficeExpenseEvent($expense, 'status'));
            }
        }
    }

    public function saving(OfficeExpense $expense)
    {
        // Cannot put in creating, because saving is fired before creating. And we need company id for check bellow
        if (company()) {
            $expense->company_id = company()->id;
        }
    }

    public function deleting(OfficeExpense $expense)
    {
        File::delete('user-uploads/expense-invoice/' . $expense->bill);
        
        $notifiData = ['App\Notifications\NewExpenseAdmin', 'App\Notifications\NewExpenseMember','App\Notifications\NewExpenseStatus'];

        $notifications = Notification::
        whereIn('type', $notifiData)
            ->whereNull('read_at')
            ->where('company_id',company()->id)
            ->where('data', 'like', '{"id":'.$expense->id.',%')
            ->delete();
    }

    public function updating(OfficeExpense $expense)
    {
        $original = $expense->getOriginal();
        if ($expense->isDirty('bill')) {
            File::delete('user-uploads/expense-invoice/' . $original['bill']);
        }
    }

}
