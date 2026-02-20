<?php

namespace BoletoSimples;

class ResponseError extends \Exception {
  /**
   * GuzzleHttp\Psr7\Response object
   */
  public $response = null;

  /**
   * Constructor method.
   */
  public function __construct($response) {
    $this->response = $response;

    $json = json_decode((string) $response->getBody(), true);
    if (isset($json['error'])) {
      $this->message = $json['error'];
      throw $this;
    }
  }
}