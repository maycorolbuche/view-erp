<?php

namespace Tests\Feature;

use App\Helpers\BirthdayHelper;
use App\Http\Controllers\BirthdayController;
use App\Models\User;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use Carbon\CarbonImmutable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BirthdaysTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));

        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table): void {
            $table->increments('id_user');
            $table->string('name');
            $table->date('birth_date')->nullable();
            $table->boolean('active')->default(true);
        });
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2026-12-30 12:00:00'));
    }

    protected function tearDown(): void
    {
        CarbonImmutable::setTestNow();
        parent::tearDown();
    }

    public function test_dashboard_orders_next_birthdays_across_years_and_limits_results(): void
    {
        $this->addUser('Janeiro', '1995-01-01');
        $this->addUser('Ontem', '1980-12-29');
        $this->addUser('Amanhã', '2000-12-31');
        $this->addUser('Hoje', '1990-12-30');
        $this->addUser('Inativo', '1990-12-30', false);
        $this->addUser('Sem data', null);
        $this->addUser('Data inválida', '0000-00-00');

        $birthdays = BirthdayHelper::upcoming();
        $this->assertSame(['Hoje', 'Amanhã', 'Janeiro'], $birthdays->pluck('name')->all());
        $this->assertTrue($birthdays[0]['today']);
        $this->assertFalse($birthdays[1]['today']);
        $this->assertSame('2027-01-01', $birthdays[2]['next']->toDateString());
    }

    public function test_directory_groups_every_user_by_month_and_separates_missing_dates(): void
    {
        $this->addUser('Fim do mês', '1980-05-30');
        $this->addUser('Inativo', '2000-05-02', false);
        $this->addUser('Janeiro', '1990-01-05');
        $this->addUser('Sem data', null);
        $this->addUser('Inválida', '2001-02-29');

        $data = (new BirthdayController())->index()->getData();
        $this->assertSame(['Inativo', 'Fim do mês'], $data['birthdaysByMonth'][5]->pluck('name')->all());
        $this->assertSame(['Janeiro'], $data['birthdaysByMonth'][1]->pluck('name')->all());
        $this->assertCount(12, $data['months']);
        $this->assertSame('02/05', $data['birthdaysByMonth'][5]->first()['date']);
    }

    public function test_february_29_is_preserved_and_observed_on_march_1_in_common_years(): void
    {
        $this->addUser('Bissexto', '2000-02-29');
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2027-03-01 10:00:00'));
        $birthday = BirthdayHelper::upcoming()->first();
        $this->assertTrue($birthday['today']);
        $this->assertSame('29/02', $birthday['date']);

        CarbonImmutable::setTestNow(CarbonImmutable::parse('2027-03-02 10:00:00'));
        $this->assertSame('2028-02-29', BirthdayHelper::upcoming()->first()['next']->toDateString());
        CarbonImmutable::setTestNow(CarbonImmutable::parse('2028-02-29 23:59:00'));
        $this->assertTrue(BirthdayHelper::upcoming()->first()['today']);
    }

    public function test_no_birthdays_returns_an_empty_collection(): void
    {
        $this->assertCount(0, BirthdayHelper::upcoming());
        $this->addUser('Sem data', null);
        $this->assertCount(0, BirthdayHelper::upcoming());
    }

    public function test_birthday_card_uses_initials_and_escapes_names(): void
    {
        $this->addUser('João da Simva Martes', '1990-12-30');
        $birthday = BirthdayHelper::upcoming()->first();
        $this->assertSame('JM', $birthday['initials']);
        $this->blade('<x-birthday :birthday="$birthday" />', compact('birthday'))
            ->assertSee('JM')->assertSee('João da Simva Martes')->assertSee('Hoje')
            ->assertSee('30/12')->assertDontSee('<img', false)->assertDontSee('1990');

        $birthday['name'] = '<script>alert(1)</script>';
        $this->blade('<x-birthday :birthday="$birthday" />', compact('birthday'))
            ->assertSee('&lt;script&gt;', false)->assertDontSee('<script>', false);
    }

    public function test_birthday_directory_requires_an_active_authenticated_user(): void
    {
        $this->get('/birthdays')->assertRedirect('/login');
        Event::fake([Authenticated::class]);
        $user = new User(['name' => 'Inativo', 'active' => false]);
        $user->id_user = 1;
        $this->actingAs($user)->get('/birthdays')->assertRedirect('/login');
    }

    private function addUser(string $name, ?string $birthDate, bool $active = true): void
    {
        DB::table('users')->insert(['name' => $name, 'birth_date' => $birthDate, 'active' => $active]);
    }
}
