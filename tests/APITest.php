<?php
require_once __DIR__.'/../vendor/autoload.php';

use LovelyTable\Config;

class APITest extends PHPUnit\Framework\TestCase{
    protected $client;

    protected function setUp() {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => Config::API_PAGE,
			'verify' => false
        ]);
    }

    public function testGetList() {
        $response = $this->client->get('', []);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);
		for($i=0;$i<10;$i++){
			$this->assertArrayHasKey('id', $data[$i]);
			$this->assertArrayHasKey('name', $data[$i]);
			$this->assertArrayHasKey('username', $data[$i]);
		}
    }
	
    public function testGetUserDetail() {
		
		for($i=1;$i<=10;$i++){
			$response = $this->client->get('/users/'.$i, []);		
			$this->assertEquals(200, $response->getStatusCode());
			
			$data = json_decode($response->getBody(), true);

			$this->assertArrayHasKey('email', $data);
			$this->assertArrayHasKey('address', $data);
			$this->assertArrayHasKey('phone', $data);
			$this->assertArrayHasKey('website', $data);
			$this->assertArrayHasKey('company', $data);
		}
    }
}

?>