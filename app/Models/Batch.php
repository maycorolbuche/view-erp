<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Traits\CreatedUpdatedBy;

class Batch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    protected $table = 'batches';
    protected $primaryKey = 'id_batch';

    protected $fillable = [
        'id_user',
        'active',
        'automatic_batch',
        'expenses_count',
        'amount',
        'refundable_amount',
        'non_refundable_amount',
        'discount',
        'refund_amount',
        'user_cash',
        'extra_amount',
        'reason_extra_amount',
        'amount_paid',
        'payment_date',
        'revised_by',
        'revised_at',
        'revised_status',
        'estimated_payment_date',

    ];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        if ($this->revised_status === 'pending' && !is_null($this->revised_by)) {
            return ['type' => 'rejected', 'color' => 'danger', 'label' => 'Rejeitado'];
        }

        if ($this->revised_status === 'pending') {
            return ['type' => 'pending', 'color' => 'warning', 'label' => 'Pendente'];
        }

        if ($this->revised_status === 'analyzing') {
            return ['type' => 'analyzing', 'color' => 'info', 'label' => 'Em Revisão'];
        }

        if ($this->active) {
            return ['type' => 'reviewed', 'color' => 'info', 'label' => 'Revisado'];
        }

        return ['type' => 'closed', 'color' => 'danger', 'label' => 'Fechado'];
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_user', 'id_user');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, BatchCategory::class, 'id_batch', 'id_category')->withPivot(['amount', 'expenses_count']);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, BatchClient::class, 'id_batch', 'id_client')->withPivot(['amount', 'expenses_count']);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'id_batch', 'id_batch');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, BatchDiscount::class, 'id_batch', 'id_discount')->withPivot(['id_batch_discount', 'id_expense', 'amount', 'expense_amount']);
    }

    public function scopeMe()
    {
        return $this->where('id_user', Auth::id());
    }
    public function scopeActive()
    {
        return $this->where('active', true);
    }
    public function scopeReviewPending()
    {
        return $this->active()->whereIn('revised_status',  ['pending', 'analyzing']);
    }
    public function scopePaymentPending()
    {
        return $this->active()->where('revised_status',  'approved');
    }
}
