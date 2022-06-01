<?php

namespace App\Models;

use App\Services\ExpenseService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    protected $fillable = ['date', 'title', 'amount'];

    public static function list()
    {
        $list = self::orderBy('date')
            ->paginate();

        return $list;
    }
}
