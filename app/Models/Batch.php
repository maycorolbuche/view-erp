<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Batch extends Model
{
    use HasFactory, CreatedUpdatedBy;

    public const STATUSES = [
        'rejected' => [
            'type' => 'rejected',
            'color' => 'danger',
            'label' => 'Rejeitado',
        ],
        'pending' => [
            'type' => 'pending',
            'color' => 'warning',
            'label' => 'Pendente p/ Análise',
        ],
        'analyzing' => [
            'type' => 'analyzing',
            'color' => 'info',
            'label' => 'Em Revisão',
        ],
        'reviewed' => [
            'type' => 'reviewed',
            'color' => 'info',
            'label' => 'Aprovado',
        ],
        'closed' => [
            'type' => 'closed',
            'color' => 'success',
            'label' => 'Concluído',
        ],
    ];

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
        'notes'
    ];

    protected $appends = ['status'];

    public function getStatusAttribute()
    {
        if ($this->revised_status === 'pending' && !is_null($this->revised_by)) {
            return self::STATUSES['rejected'];
        }

        if ($this->revised_status === 'pending') {
            return self::STATUSES['pending'];
        }

        if ($this->revised_status === 'analyzing') {
            return self::STATUSES['analyzing'];
        }

        if ($this->active) {
            return self::STATUSES['reviewed'];
        }

        return self::STATUSES['closed'];
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

    public function scopeMe($query)
    {
        return $query->where('id_user', auth()->id());
    }
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    public function scopeReviewPending($query)
    {
        return $query->active()->whereIn('revised_status',  ['pending', 'analyzing']);
    }
    public function scopePaymentPending($query)
    {
        return $query->active()->where('revised_status',  'approved');
    }
    public function scopeStatus($query, string $status)
    {
        if (!isset(self::STATUSES[$status])) {
            return $query;
        }

        return match ($status) {
            'rejected' => $query
                ->where('revised_status', 'pending')
                ->whereNotNull('revised_by'),

            'pending' => $query
                ->where('revised_status', 'pending')
                ->whereNull('revised_by'),

            'analyzing' => $query
                ->where('revised_status', 'analyzing'),

            'reviewed' => $query
                ->where('active', true)
                ->whereNotIn('revised_status', ['pending', 'analyzing']),

            'closed' => $query
                ->where('active', false)
                ->whereNotIn('revised_status', ['pending', 'analyzing']),
        };
    }
}
