<?php

namespace App\Services;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    public static function store($data)
    {
        $personalExpense = new Expense();
        if (isset($data['id'])) {
            $personalExpense->id = $data['id'];
            $personalExpense->exists = true;
        }
        $personalExpense->date = $data['date'];
        $personalExpense->title = $data['title'];
        $personalExpense->amount = $data['amount'];
        $personalExpense->save();
        return $personalExpense;
    }

    public static function getSummary()
    {
        $lastDate = now()->subDays(7)->format('Y-m-d');
        $eleq = Expense::where('date', '>', $lastDate);
        $totalEleq = clone $eleq;
        $totalAmount = $totalEleq->sum('amount');
        $dailyEleq = clone $eleq;
        $dailyRecords = $dailyEleq->select('date', DB::raw('SUM(amount) as amount'))
            ->groupBy('date')
            ->get();

        $summary = [];
        foreach ($dailyRecords as $record) {
            $day = Carbon::createFromFormat('Y-m-d', $record->date)->format('D');
            $summary[] = [
                'day' => $day,
                'amount' => $record->amount,
                'percentage' => round(($record->amount / $totalAmount) * 100, 2)
            ];
        }

        return $summary;
    }
}
