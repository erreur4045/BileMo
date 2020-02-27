<?php
/**
 * Create by maxime
 * Date 2/25/2020
 * Time 5:59 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUsersTest.php as GetEndUsersTest
 */

namespace App\Tests\Actions;

use App\Tests\AbstractTestCase;

class GetEndUsersUnpaginatedTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
        parent::reloadDataFixtures(true);
    }
    public function testGetUsersWithoutAuth()
    {
        $response = $this->request('GET', '/api/clients/42/users');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetUsersWithAuth()
    {
        $response = $this->request('GET', '/api/clients/1/users', 'darty', 'testpass');
        $this->assertEquals(200, $response->getStatusCode());
    }
    public function testGetListUsersOnExsistingPage()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/clients/1/users?page=1', 'darty', 'testpass');
        static::assertEquals(200, $response->getStatusCode());
    }

    public function testGetUsersPhonesOnNoneExsistingPage()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/clients/1/users?page=40', 'darty', 'testpass');
        static::assertEquals(400, $response->getStatusCode());
    }

    public function testGetUsersPhonesWithInvalidParamForPaginate()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/clients/1/users?page=asdsad40', 'darty', 'testpass');
        static::assertEquals(404, $response->getStatusCode());
    }

    public function testGetUsersWithAuthWithAnotherClientId()
    {
        $response = $this->request('GET', '/api/clients/2/users', 'darty', 'testpass');
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetUsersWithBadParam()
    {
        $response = $this->request('GET', '/api/clients/sdf/users', 'darty', 'testpass');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetUsersWithAuthOnBadMethod()
    {
        $response = $this->request('DELETE', '/api/clients/1/users', 'darty', 'testpass');
        $this->assertEquals(405, $response->getStatusCode());
    }
}