<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class ExpenseClient extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses_clients';
    protected $primaryKey = 'id_expense_client';

    protected $fillable = [
        'id_expense',
        'id_client',
        'amount',
        'percentage',
    ];


    public function expense()
    {
        return $this->hasOne(Expense::class, 'id_expense', 'id_expense');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id_client', 'id_client');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }
}
