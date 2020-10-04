<?php

namespace App\Tests\Models;
use App\Models\SalaryDateModel;
use PHPUnit\Framework\TestCase;

class SalaryDateModelTests extends TestCase
{
    public function testGenerateData()
    {
        $salaryDates = new SalaryDateModel();
        $data = $salaryDates->generateData();

        $this->assertTrue(is_array($data));
        $this->assertCount(12,$data);

        foreach ($data as $record){

            //Detailed test make sure we have dates
            $this->assertArrayHasKey('month', $record);
            $this->assertStringMatchesFormat('%a%e%d', $record['month']);

            $this->assertArrayHasKey('bonusDay', $record);
            $this->assertStringMatchesFormat('%d%a%d%a%d', $record['bonusDay']);

            $testDateObject = new \DateTime($record['bonusDay']);
            $this->assertInstanceOf(\DateTime::class, $testDateObject);
            $day = $testDateObject->format('l');
            $this->assertNotEquals('Saturday', $day);
            $this->assertNotEquals('Sunday', $day);

            $this->assertArrayHasKey('payDay', $record);
            $this->assertStringMatchesFormat('%d%a%d%a%d', $record['payDay']);

            $testDateObject = new \DateTime($record['payDay']);
            $this->assertInstanceOf(\DateTime::class, $testDateObject);
            $day = $testDateObject->format('l');
            $this->assertNotEquals('Saturday', $day);
            $this->assertNotEquals('Sunday', $day);
        }
    }
}