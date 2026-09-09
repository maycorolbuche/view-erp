<?php

namespace Tests\Unit;

use App\Models\Batch;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ModelScopesTest extends TestCase
{
    public function test_batch_active_scope_filters_active_records(): void
    {
        $query = Batch::query()->active()->getQuery();

        $this->assertSame('active', $query->wheres[0]['column']);
        $this->assertTrue($query->wheres[0]['value']);
    }

    public function test_batch_review_pending_scope_combines_active_and_status_filters(): void
    {
        $query = Batch::query()->reviewPending()->getQuery();

        $this->assertSame('active', $query->wheres[0]['column']);
        $this->assertSame(['pending', 'analyzing'], $query->wheres[1]['values']);
    }

    public function test_batch_me_scope_uses_authenticated_user(): void
    {
        Auth::shouldReceive('id')->once()->andReturn(42);

        $query = Batch::query()->me()->getQuery();

        $this->assertSame('id_user', $query->wheres[0]['column']);
        $this->assertSame(42, $query->wheres[0]['value']);
    }

    public function test_expense_without_batch_scope_filters_null_batch(): void
    {
        $query = Expense::query()->withoutBatch()->getQuery();

        $this->assertSame('Null', $query->wheres[0]['type']);
        $this->assertSame('id_batch', $query->wheres[0]['column']);
    }

    public function test_expense_batch_scope_filters_requested_batch(): void
    {
        $query = Expense::query()->batch(15)->getQuery();

        $this->assertSame('id_batch', $query->wheres[0]['column']);
        $this->assertSame(15, $query->wheres[0]['value']);
    }
}
