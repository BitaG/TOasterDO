<?php
require  "../application/core/route.php";

class RouteTest extends \PHPUnit\Framework\TestCase
{

    public function testGet_routes()
    {
        $routes = Route::get_routes();
        $this->assertNotNull($routes);
    }



}
