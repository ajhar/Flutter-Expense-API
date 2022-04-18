<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Http\Resources\ExpenseSummaryResource;
use App\Models\Expense;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ExpenseResource::collection(Expense::list());
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
    public function show($id)
    {
        return new ExpenseResource(Expense::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return ExpenseResource
     */
    public function update(UpdateExpenseRequest $request, $id)
    {
        $expense = [
            'id' => $id,
            'date' => $request->date,
            'title' => $request->title,
            'amount' => $request->amount
        ];

        return new ExpenseResource(ExpenseService::store($expense));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();
        return response()->noContent(200);
    }

    public function getSummary()
    {
        return new ExpenseSummaryResource(ExpenseService::getSummary());
    }
}
