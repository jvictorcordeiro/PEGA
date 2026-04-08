<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class AuthRoutesTest extends TestCase
{
    /** @test */
    public function it_registers_the_expected_auth_route_names()
    {
        $this->assertNotNull(Route::getRoutes()->getByName('login'));
        $this->assertNotNull(Route::getRoutes()->getByName('register'));
        $this->assertNotNull(Route::getRoutes()->getByName('logout'));
        $this->assertNotNull(Route::getRoutes()->getByName('password.request'));
        $this->assertNotNull(Route::getRoutes()->getByName('password.email'));
        $this->assertNotNull(Route::getRoutes()->getByName('password.reset'));
        $this->assertNotNull(Route::getRoutes()->getByName('password.update'));
        $this->assertNotNull(Route::getRoutes()->getByName('verification.notice'));
        $this->assertNotNull(Route::getRoutes()->getByName('verification.verify'));
        $this->assertNotNull(Route::getRoutes()->getByName('verification.resend'));
    }

    /** @test */
    public function it_keeps_http_methods_compatible_with_legacy_forms()
    {
        $this->assertEquals(['GET', 'HEAD'], Route::getRoutes()->getByName('login')->methods());
        $this->assertEquals(['POST'], Route::getRoutes()->getByName('logout')->methods());
        $this->assertEquals(['POST'], Route::getRoutes()->getByName('password.email')->methods());
        $this->assertEquals(['POST'], Route::getRoutes()->getByName('password.update')->methods());
    }
}
