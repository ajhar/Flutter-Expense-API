<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseSummaryResource;
use App\Models\Expense;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ExpenseResource::collection(Expense::list())->additional([
            'summary' => ExpenseService::getSummary()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreExpenseRequest $request
     * @return ExpenseResource
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = [
            'date' => $request->date,
            'title' => $request->title,
            'amount' => $request->amount
        ];

        return new ExpenseResource(ExpenseService::store($expense));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ExpenseResource
     */
    public function show(Expense $expense)
    {
        $summary = ExpenseService::getSummary();
        $expense->summary = $summary;
        return new ExpenseResource($expense);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return ExpenseResource
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $data = [
            'date' => $request->date,
            'title' => $request->title,
            'amount' => $request->amount
        ];

        return new ExpenseResource(ExpenseService::update($expense, $data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        $summary = ExpenseService::getSummary();
        $request = new Request();
        $request->merge(['summary' => $summary]);
        return new ExpenseResource($request);
    }

    public function getSummary()
    {
        return new ExpenseSummaryResource(ExpenseService::getSummary());
    }
}
