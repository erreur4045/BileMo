<?php
/**
 * Create by maxime
 * Date 2/25/2020
 * Time 9:38 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : PostEndUsersTest.php as PostEndUsersTest
 */

namespace App\Tests\Actions;


use App\Tests\AbstractTestCase;

class PostEndUserTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testPostUserWithoutAuth()
    {
        $response = $this->request('POST', '/api/clients/42/users');

        $this->assertEquals(401, $response->getStatusCode());
    }

    public function testPostUserWithAuth()
    {
        $response = $this->request(
            'POST',
            '/api/clients/1/users',
            'darty',
            'testpass',
            "{
              \"lastname\": \"Darty\",
              \"fistname\": \"testpsass\",
              \"email\": \"testsssddf@test.test\"
               }"
        );

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testPostUserWithAuthSameUserTwice()
    {
        $response = $this->request(
            'POST',
            '/api/clients/1/users',
            'darty',
            'testpass',
            "{
              \"lastname\": \"Darty\",
              \"fistname\": \"testpsass\",
              \"email\": \"testsssddf@test.test\"
               }"
        );

        $response = $this->request(
            'POST',
            '/api/clients/1/users',
            'darty',
            'testpass',
            "{
              \"lastname\": \"Darty\",
              \"fistname\": \"testpsass\",
              \"email\": \"testsssddf@test.test\"
               }"
        );

        $this->assertEquals(409, $response->getStatusCode());
    }

    public function testPostUserWithAuthAndBadContent()
    {
        $response = $this->request(
            'POST',
            '/api/clients/1/users',
            'darty',
            'testpass',
            "{
              \"lastnafdgme\": \"Darty\",
              \"fistname\": \"testpsass\",
              \"email\": \"testsssddf@test.test\"
               }"
        );

        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testPostUserWithAuthAndNoContent()
    {
        $response = $this->request('POST','/api/clients/1/users','darty','testpass');
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testPostUserWithAuthAndEmptyContent()
    {
        $response = $this->request('POST','/api/clients/1/users','darty','testpass', "{}");
        $this->assertEquals(400, $response->getStatusCode());
    }

    public function testPostUserWithAuthAndBadIdClient()
    {
        $response = $this->request(
            'POST',
            '/api/clients/2/users',
            'darty',
            'testpass',
            "{
              \"lastname\": \"Darty\",
              \"fistname\": \"testpsass\",
              \"email\": \"testsssddf@test.test\"
               }"
        );
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testDeleteUserWithBadMethod()
    {
        $response = $this->request('PUT', '/api/clients/1/users','darty','testpass');
        $this->assertEquals(405, $response->getStatusCode());
    }
}