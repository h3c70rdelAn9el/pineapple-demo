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

    /**
     * Test that getCurrencySymbol returns correct symbols for different currencies.
     */
    public function test_get_currency_symbol_returns_correct_symbols(): void
    {
        $controller = new TherapistsController();
        $reflection = new ReflectionMethod(TherapistsController::class, 'getCurrencySymbol');
        $reflection->setAccessible(true);

        // Test various currencies
        $this->assertEquals('$', $reflection->invoke($controller, 'USD'));
        $this->assertEquals('£', $reflection->invoke($controller, 'GBP'));
        $this->assertEquals('€', $reflection->invoke($controller, 'EUR'));
        $this->assertEquals('¥', $reflection->invoke($controller, 'JPY'));
        $this->assertEquals('A$', $reflection->invoke($controller, 'AUD'));
        $this->assertEquals('C$', $reflection->invoke($controller, 'CAD'));

        // Test default fallback for unknown currency
        $this->assertEquals('$', $reflection->invoke($controller, 'UNKNOWN'));
        
        // Test null currency defaults to USD
        $this->assertEquals('$', $reflection->invoke($controller, null));
    }
}
