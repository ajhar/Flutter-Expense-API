<?php

namespace App\Services;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    public static function store($data)
    {
        $expense = new Expense();
        $expense->date = $data['date'];
        $expense->title = $data['title'];
        $expense->amount = $data['amount'];
        $expense->save();
        $expense->summary = self::getSummary();
        return $expense;
    }

    public static function update($expense, $data)
    {
        $expense->date = $data['date'];
        $expense->title = $data['title'];
        $expense->amount = $data['amount'];
        $expense->save();
        $expense->summary = self::getSummary();
        return $expense;
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
                'amount' => round($record->amount, 2),
                'percentage' => round(($record->amount / $totalAmount) * 100, 2)
            ];
        }

        return $summary;
    }
}
