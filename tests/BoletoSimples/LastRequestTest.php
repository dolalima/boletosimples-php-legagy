<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;

class LastRequestTest extends TestCase {

	public function testConstructor () {
    $response = new Response(200, [
      'Total' => '110',
      'X-Ratelimit-Limit' => '500',
      'X-Ratelimit-Remaining' => '498',
      'Link' => '<https://api-sandbox.kobana.com.br/v1/bank_billets?page=55&per_page=2>; rel="last", <https://api-sandbox.kobana.com.br/v1/bank_billets?page=2&per_page=2>; rel="next"'
    ]);

    $this->subject = new BoletoSimples\LastRequest($response);

    $this->assertEquals($this->subject->response, $response);
    $this->assertEquals($this->subject->total, '110');
    $this->assertEquals($this->subject->ratelimit_limit, '500');
    $this->assertEquals($this->subject->ratelimit_remaining, '498');
    $this->assertEquals($this->subject->links['last'], 'https://api-sandbox.kobana.com.br/v1/bank_billets?page=55&per_page=2');
    $this->assertEquals($this->subject->links['next'],'https://api-sandbox.kobana.com.br/v1/bank_billets?page=2&per_page=2');
	}
}
