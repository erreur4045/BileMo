<?php
/**
 * Create by maxime
 * Date 2/25/2020
 * Time 9:11 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : DeleteEndUserTest.php as DeleteEndUserTest
 */

namespace App\Tests\Actions;


use App\Tests\AbstractTestCase;

class DeleteEndUserTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
        parent::reloadDataFixtures();
    }

    public function testDeleteUserWithoutAuth()
    {
        $response = $this->request('DELETE', '/api/clients/42/users/1');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testDeleteUserWithAuth()
    {
        $response = $this->request('DELETE', '/api/clients/1/users/14', 'darty', 'testpass');

        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testDeleteUserTwice()
    {
        $this->request('DELETE', '/api/clients/1/users/14', 'darty', 'testpass');
        $response = $this->request('DELETE', '/api/clients/1/users/14', 'darty', 'testpass');

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteUserFromAnotherClient()
    {
        $response = $this->request('DELETE', '/api/clients/2/users/39', 'darty', 'testpass');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testDeleteUserWithBadParam()
    {
        $response = $this->request('DELETE', '/api/clients/1dsff/users/14', 'darty', 'testpass');

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteUserWithANonExistentUser()
    {
        $response = $this->request('DELETE', '/api/clients/1/users/1445', 'darty', 'testpass');

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteUserWithBadMethod()
    {
        $response = $this->request('PUT', '/api/clients/1/users/11');
        $this->assertEquals(405, $response->getStatusCode());
    }
}