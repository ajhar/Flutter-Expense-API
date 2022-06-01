<?php

namespace App\Services;

use App\Models\Expense;
use Carbon\CarbonPeriod;
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
        $now = now()->format('Y-m-d');
        $lastDate = now()->subDays(6)->format('Y-m-d');

        $period = CarbonPeriod::create($lastDate, $now);

        $summary = [];
        foreach ($period as $day) {
            $summary[$day->format('Y-m-d')] = [
                'day' => $day->format('D'),
                'amount' => 0,
                'percentage' => 0
            ];
        }

        $eleq = Expense::where('date', '>', $lastDate);

        $totalEleq = clone $eleq;
        $totalAmount = $totalEleq->sum('amount');

        $dailyEleq = clone $eleq;
        $dailyRecords = $dailyEleq->select('date', DB::raw('SUM(amount) as amount'))
            ->groupBy('date')
            ->get();

        foreach ($dailyRecords as $record) {
            $date = $record->date;
            $summary[$date]['amount'] = round($record->amount, 2);
            $summary[$date]['percentage'] = round(($record->amount / $totalAmount) * 100, 2);
        }

        return array_values($summary);
    }
}
