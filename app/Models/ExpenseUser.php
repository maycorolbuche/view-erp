<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class ExpenseUser extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses_users';
    protected $primaryKey = 'id_expense_user';

    protected $fillable = [
        'id_expense',
        'id_user',
        'amount',
        'percentage',
    ];


    public function expense(): HasOne
    {
        return $this->hasOne(Expense::class, 'id_expense', 'id_expense');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }
}
