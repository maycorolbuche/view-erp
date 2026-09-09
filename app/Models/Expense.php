<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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
        'id_file',
        'revised_by',
        'revised_at',
        'revised',
    ];

    public function authorization(): HasOne
    {
        return $this->hasOne(Authorization::class, 'id_authorization', 'id_authorization');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id_category', 'id_category');
    }

    public function payment_method(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, 'id_payment_method', 'id_payment_method');
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, ExpenseClient::class, 'id_expense', 'id_client')->withPivot(['amount', 'percentage', 'id_expense_client']);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, ExpenseUser::class, 'id_expense', 'id_user')->withPivot(['amount', 'percentage', 'id_expense_user']);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function batch(): HasOne
    {
        return $this->hasOne(Batch::class, 'id_batch', 'id_batch');
    }

    public function file(): HasOne
    {
        return $this->hasOne(File::class, 'id_file', 'id_file');
    }

    public function scopeMe(Builder $query): Builder
    {
        return $query->where('id_user', Auth::id());
    }
    public function scopeWithoutBatch(Builder $query): Builder
    {
        return $query->whereNull('id_batch');
    }
    public function scopeActiveAuthorization(Builder $query): Builder
    {
        return $query->whereHas('authorization', function (Builder $q) {
            $q->where('active', true);
        });
    }
    public function scopeInactiveAuthorization(Builder $query): Builder
    {
        return $query->whereHas('authorization', function (Builder $q) {
            $q->where('active', false);
        });
    }
    public function scopeBatch(Builder $query, int|string $id_batch): Builder
    {
        return $query->where('id_batch', $id_batch);
    }
}
