<?php
/**
 * Create by maxime
 * Date 2/24/2020
 * Time 2:19 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : GetPhonesTest.php as GetPhonesTest
 */

namespace App\Tests\Actions;


use App\Tests\AbstractTestCase;

class GetPhonesTest extends AbstractTestCase
{
    protected function setUp()
    {
        parent::setUp();
        parent::reloadDataFixtures();
    }

    public function testGetListPhones()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones/', 'darty', 'testpass');
        static::assertEquals(200, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);
        static::assertIsArray($content,"OK" );
        static::assertArrayHasKey('Phone',$content);
        static::assertArrayHasKey('pagination',$content);
        static::assertArrayHasKey('id',$content['Phone'][0]);
        static::assertArrayHasKey('name',$content['Phone'][0]);
        static::assertArrayHasKey('price',$content['Phone'][0]);
        static::assertArrayHasKey('width',$content['Phone'][0]);
    }

    public function testGetListPhonesOnExistingPage()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones?page=1', 'darty', 'testpass');
        static::assertEquals(200, $response->getStatusCode());
        static::assertIsArray(json_decode($response->getContent(), true),"OK" );
    }

    public function testGetListPhonesOnExistingPage2()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones?page=2', 'darty', 'testpass');
        static::assertEquals(200, $response->getStatusCode());
        static::assertIsArray(json_decode($response->getContent(), true),"OK" );
    }

    public function testGetListPhonesOnNoneExistingPage()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones/?page=40', 'darty', 'testpass');
        static::assertEquals(400, $response->getStatusCode());
        static::assertIsArray(json_decode($response->getContent(), true),"OK" );
    }

    public function testGetListPhonesWithInvalidParamForPaginate()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones/?page=40', 'darty', 'testpass');
        static::assertEquals(400, $response->getStatusCode());
    }

    public function testGetListPhonesWithInvalidParamIntForPaginate()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones/?page=40sdfsdf', 'darty', 'testpass');
        static::assertEquals(400, $response->getStatusCode());
    }

    public function testGetListPhonesWithoutAuth()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('GET', '/api/phones?page=1');
        static::assertEquals(401, $response->getStatusCode());
    }
    public function testGetListPhonesWithBadMethod()
    {
        $this->clientAPI->followRedirects(true);
        $response = $this->request('DELETE', '/api/phones', 'darty', 'testpass');
        static::assertEquals(405, $response->getStatusCode());
    }
}