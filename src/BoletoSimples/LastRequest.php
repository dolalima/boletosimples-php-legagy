<?php

namespace BoletoSimples;

class LastRequest {
  /**
   * Content of response header Total
   */
  public $total = null;

  /**
   * Content of response header X-Ratelimit-Limit
   */
  public $ratelimit_limit = null;

  /**
   * Content of response header X-Ratelimit-Remaining
   */
  public $ratelimit_remaining = null;

  /**
   * Array with links returned on header Link
   */
  public $links = null;

  /**
   * GuzzleHttp\Psr7\Response object
   */
  public $response = null;

  /**
   * Constructor method.
   */
  public function __construct($response) {
    $this->response = $response;

    $this->total = $response->getHeaderLine('Total') ?: null;
    $this->ratelimit_limit = $response->getHeaderLine('X-Ratelimit-Limit') ?: null;
    $this->ratelimit_remaining = $response->getHeaderLine('X-Ratelimit-Remaining') ?: null;
    $this->links = $this->getLinks($response);
  }

  private function getLinks($response) {
    $link_header = $response->getHeaderLine('Link');
    if (empty($link_header)) {
      return [];
    }
    $links = [];
    foreach (explode(', ', $link_header) as $link) {
      preg_match('/rel=\"(.*)\"/', $link, $matches);
      $key = $matches[1];
      preg_match('/\<(.*)\>/', $link, $matches);
      $value = $matches[1];
      $links[$key] = $value;
    }
    return $links;
  }
}