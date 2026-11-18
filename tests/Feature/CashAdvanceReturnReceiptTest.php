<?php

namespace Tests\Feature;

use App\Http\Controllers\Authorization\AuthorizationCashAdvanceReturnController;
use App\Models\Authorization;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CashAdvanceReturnReceiptTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'app.key' => 'base64:' . base64_encode(str_repeat('a', 32)),
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        Storage::fake('public');

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('name');
        });
        Schema::create('users_cash', function (Blueprint $table) {
            $table->increments('id_user_cash');
            $table->unsignedInteger('id_user');
            $table->decimal('amount', 8, 2);
        });
        Schema::create('authorizations_types', function (Blueprint $table) {
            $table->increments('id_authorization_type');
            $table->string('name');
            $table->string('type');
        });
        Schema::create('users_authorizations_types', function (Blueprint $table) {
            $table->unsignedInteger('id_authorization_type');
            $table->unsignedInteger('id_user_child');
            $table->unsignedInteger('id_user_parent');
        });

        require_once database_path('migrations/2023_11_15_190020_create_authorizations_table.php');
        (new \CreateAuthorizationsTable)->up();
        require_once database_path('migrations/2023_11_15_190220_create_authorizations_statuses_table.php');
        (new \CreateAuthorizationsStatusesTable)->up();
        (require database_path('migrations/2023_11_24_191924_create_files_table.php'))->up();
        $this->receiptMigration()->up();

        DB::table('users')->insert([
            ['id_user' => 1, 'name' => 'Colaborador'],
            ['id_user' => 2, 'name' => 'Responsável'],
        ]);
        DB::table('users_cash')->insert(['id_user' => 1, 'amount' => 100]);
        DB::table('authorizations_types')->insert([
            'id_authorization_type' => 1, 'name' => 'Devolução', 'type' => 'cash-advance-return',
        ]);
        DB::table('users_authorizations_types')->insert([
            'id_authorization_type' => 1, 'id_user_child' => 1, 'id_user_parent' => 2,
        ]);
        $this->actingAs(User::find(1));

        Route::middleware('web')->post('/test/cash-advance-return', function (
            \App\Http\Requests\AuthorizationCashAdvanceReturnRequest $request
        ) {
            $request->merge(['__permissions_page' => ['store']]);
            return app(AuthorizationCashAdvanceReturnController::class)->store($request);
        });
        Route::get('/test/cash-advance-returns', fn () => 'OK')->name('authorizations-cash-advance-returns');
    }

    public function test_receipt_is_required_even_when_an_existing_file_id_is_submitted(): void
    {
        $this->post('/test/cash-advance-return', $this->payload() + ['id_file' => 123])
            ->assertSessionHasErrors('file');

        $this->assertDatabaseCount('authorizations', 0);
        $this->assertDatabaseCount('files', 0);
    }

    public function test_invalid_file_type_is_rejected(): void
    {
        $this->post('/test/cash-advance-return', $this->payload() + [
            'file' => UploadedFile::fake()->create('comprovante.txt', 1, 'text/plain'),
        ])->assertSessionHasErrors('file');

        $this->assertDatabaseCount('authorizations', 0);
    }

    public function test_receipt_larger_than_twenty_megabytes_is_rejected(): void
    {
        $this->post('/test/cash-advance-return', $this->payload() + [
            'file' => $this->pdf()->size(20481),
        ])->assertSessionHasErrors('file');
    }

    public function test_receipt_is_stored_and_linked_to_the_return_and_approvers(): void
    {
        $this->post('/test/cash-advance-return', $this->payload() + [
            'file' => $this->pdf(), 'id_file' => 999,
        ])->assertSessionHasNoErrors()->assertSessionHas('success');

        $authorization = Authorization::firstOrFail();
        $this->assertEquals(-50, $authorization->amount);
        $this->assertNotEquals(999, $authorization->id_file);
        $this->assertSame('comprovante.pdf', $authorization->file->original_name);
        Storage::disk('public')->assertExists($authorization->file->path);
        $this->assertDatabaseHas('authorizations_statuses', [
            'id_authorization' => $authorization->id_authorization, 'id_user' => 2,
        ]);
    }

    public function test_image_receipt_passes_validation(): void
    {
        $request = new \App\Http\Requests\AuthorizationCashAdvanceReturnRequest;
        $validator = \Illuminate\Support\Facades\Validator::make($this->payload() + [
            'file' => UploadedFile::fake()->image('comprovante.png'),
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }

    public function test_failed_save_rolls_back_the_return_and_removes_the_uploaded_file(): void
    {
        Schema::drop('authorizations_statuses');

        $this->post('/test/cash-advance-return', $this->payload() + ['file' => $this->pdf()])
            ->assertSessionHas('error');

        $this->assertDatabaseCount('authorizations', 0);
        $this->assertDatabaseCount('files', 0);
        $this->assertSame([], Storage::disk('public')->allFiles('cash-advance-returns'));
    }

    public function test_migration_allows_existing_authorizations_without_a_receipt(): void
    {
        DB::table('authorizations')->insert([
            'id_user' => 1, 'id_authorization_type' => 1, 'description' => 'Devolução antiga',
            'start_datetime' => now(), 'end_datetime' => now(),
        ]);
        $this->assertNull(DB::table('authorizations')->value('id_file'));
    }

    public function test_rollback_generates_the_foreign_key_and_column_removal_for_mysql(): void
    {
        // SQLite cannot drop foreign keys; production uses MySQL.
        $connection = DB::connection();
        $originalGrammar = $connection->getSchemaGrammar();
        $connection->setSchemaGrammar(new \Illuminate\Database\Schema\Grammars\MySqlGrammar);
        try {
            $queries = $connection->pretend(fn () => $this->receiptMigration()->down());
        } finally {
            $connection->setSchemaGrammar($originalGrammar);
        }
        $sql = implode("\n", array_column($queries, 'query'));
        $this->assertStringContainsString('drop foreign key `authorizations_id_file_foreign`', $sql);
        $this->assertStringContainsString('drop `id_file`', $sql);
    }

    private function payload(): array
    {
        return ['amount' => 50, 'description' => 'Devolução do saldo'];
    }

    private function pdf(): UploadedFile
    {
        return UploadedFile::fake()->createWithContent('comprovante.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF");
    }

    private function receiptMigration(): \Illuminate\Database\Migrations\Migration
    {
        return require database_path('migrations/2026_11_18_000001_add_receipt_to_authorizations_table.php');
    }
}
