<?php
/**
 * Create by maxime
 * Date 2/25/2020
 * Time 7:13 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetEndUserTest.php as GetEndUserTest
 */

namespace App\Tests\Actions;


use App\Tests\AbstractTestCase;

class GetEndUserTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testGetUserWithoutAuth()
    {
        $response = $this->request('GET', '/api/clients/42/users/1');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetUserWithAuth()
    {
        $response = $this->request('GET', '/api/clients/1/users/14', 'darty', 'testpass');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetUserWithAuthOnUnexistUser()
    {
        $response = $this->request('GET', '/api/clients/1/users/14566', 'darty', 'testpass');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetUserWithAuthOnExistUserWithNoAccessToThisRessource()
    {
        $response = $this->request('GET', '/api/clients/2/users/50', 'darty', 'testpass');
        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testGetUserWithBadParamUserId()
    {
        $response = $this->request('GET', '/api/clients/1/users/sdfdf', 'darty', 'testpass');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetUserWithBadParamClientId()
    {
        $response = $this->request('GET', '/api/clients/sdf54/users/2', 'darty', 'testpass');
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testGetUserWithAuthOnBadMethod()
    {
        $response = $this->request('PUT', '/api/clients/1/users/11', 'darty', 'testpass');
        $this->assertEquals(405, $response->getStatusCode());
    }
}