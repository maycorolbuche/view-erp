<?php

namespace Tests\Unit;

use App\Models\Authorization;
use App\Models\Expense;
use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    public function test_user_relationship_contracts(): void
    {
        $user = new User();

        $this->assertInstanceOf(BelongsToMany::class, $user->profiles());
        $this->assertInstanceOf(HasMany::class, $user->permissions());
        $this->assertInstanceOf(HasOne::class, $user->branch());
    }

    public function test_expense_relationship_contracts(): void
    {
        $expense = new Expense();

        $this->assertInstanceOf(HasOne::class, $expense->authorization());
        $this->assertInstanceOf(BelongsToMany::class, $expense->clients());
        $this->assertInstanceOf(BelongsToMany::class, $expense->users());
    }

    public function test_authorization_relationship_contracts(): void
    {
        $authorization = new Authorization();

        $this->assertInstanceOf(BelongsToMany::class, $authorization->clients());
        $this->assertInstanceOf(HasMany::class, $authorization->authorization_statuses());
        $this->assertInstanceOf(HasOne::class, $authorization->authorization_type());
    }

    public function test_notification_log_uses_polymorphic_notifiable_relation(): void
    {
        $this->assertInstanceOf(MorphTo::class, (new NotificationLog())->notifiable());
    }
}
