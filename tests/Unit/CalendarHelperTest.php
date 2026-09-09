<?php

namespace Tests\Unit;

use App\Helpers\CalendarHelper;
use DateTime;
use PHPUnit\Framework\TestCase;

class CalendarHelperTest extends TestCase
{
    public function test_zero_business_days_returns_same_date_as_a_clone(): void
    {
        $original = new DateTime('2026-09-09');

        $result = CalendarHelper::addBusinessDays($original, 0);

        $this->assertEquals($original, $result);
        $this->assertNotSame($original, $result);
    }
}
