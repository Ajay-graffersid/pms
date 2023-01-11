<?php

namespace App\Events;

use App\OfficeExpense;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOfficeExpenseEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $expense;
    public $status;

    public function __construct(OfficeExpense $expense, $status)
    {
        $this->expense = $expense;
        $this->status = $status;
    }

}
