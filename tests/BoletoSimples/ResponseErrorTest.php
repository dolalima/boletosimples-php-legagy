<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;

class ResponseErrorTest extends TestCase {

  public function testWithError () {
    $this->expectException(\BoletoSimples\ResponseError::class);
    $this->expectExceptionMessage('Você precisa se logar ou registrar antes de prosseguir.');

    $response = new Response(401, [], '{"error":"Você precisa se logar ou registrar antes de prosseguir."}');
    $this->subject = new BoletoSimples\ResponseError($response);
  }

  public function testWithoutError () {
    $response = new Response(200, [], '{}');
    $this->subject = new BoletoSimples\ResponseError($response);
    $this->assertEquals($this->subject->response, $response);
  }
}
