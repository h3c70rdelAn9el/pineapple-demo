<?php

namespace Tests\Unit;

use App\Http\Controllers\TherapistsController;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class SimpleInvoiceTest extends TestCase
{
    /**
     * Test that the sendLastMonthInvoice method exists.
     */
    public function test_send_last_month_invoice_method_exists(): void
    {
        $controller = new TherapistsController();
        $this->assertTrue(method_exists($controller, 'sendLastMonthInvoice'));
    }

    /**
     * Test that the method has the correct signature.
     */
    public function test_send_last_month_invoice_method_signature(): void
    {
        $reflection = new ReflectionMethod(TherapistsController::class, 'sendLastMonthInvoice');
        $parameters = $reflection->getParameters();
        
        $this->assertCount(1, $parameters);
        $this->assertEquals('id', $parameters[0]->getName());
    }
}
