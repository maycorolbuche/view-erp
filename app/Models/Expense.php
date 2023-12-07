<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Expense extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'expenses';
    protected $primaryKey = 'id_expense';

    protected $fillable = [
        'id_authorization',
        'id_user',
        'id_batch',
        'date',
        'id_category',
        'id_payment_method',
        'amount',
        'notes',
    ];

    public function authorization()
    {
        return $this->hasOne(Authorization::class, 'id_authorization', 'id_authorization');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }

    public function payment_method()
    {
        return $this->hasOne(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, ExpenseClient::class, 'id_expense', 'id_client')->withPivot(['amount', 'percentage', 'id_expense_client']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, ExpenseUser::class, 'id_expense', 'id_user')->withPivot(['amount', 'percentage', 'id_expense_user']);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }
}
