<?php
/**
 * Create by maxime
 * Date 2/25/2020
 * Time 12:04 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhoneWithDetailsTest.php as GetPhoneWithDetailsTest
 */

namespace App\Tests\Actions;


use App\Tests\AbstractTestCase;

class GetPhoneWithDetailsTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testGetPhoneWithoutAuth()
    {
        $response = $this->request('GET', '/api/phones/2');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetPhoneWithAuth()
    {
        $response = $this->request('GET', '/api/phones/2', 'darty', 'testpass');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetPhoneWithAuthOnUnexistPhone()
    {
        $response = $this->request('GET', '/api/phones/123', 'darty', 'testpass');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetPhoneWithBadParam()
    {
        $response = $this->request('GET', '/api/phones/123fddg', 'darty', 'testpass');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetPhoneWithAuthOnBadMethod()
    {
        $response = $this->request('DELETE', '/api/phones/2', 'darty', 'testpass');
        $this->assertEquals(405, $response->getStatusCode());
    }
}