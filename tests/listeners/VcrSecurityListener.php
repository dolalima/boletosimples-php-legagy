<?php

use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestSuite;

class VcrSecurityListener implements TestListener
{
    use TestListenerDefaultImplementation;

    private $dataChanged = null;

    private function sensitiveData() {
      return [
        'BOLETOSIMPLES_APP_ID' => getenv('BOLETOSIMPLES_APP_ID'),
        'BOLETOSIMPLES_APP_SECRET' => getenv('BOLETOSIMPLES_APP_SECRET'),
        'BOLETOSIMPLES_ACCESS_TOKEN' => getenv('BOLETOSIMPLES_ACCESS_TOKEN'),
        'BOLETOSIMPLES_CLIENT_CREDENTIALS_TOKEN' => getenv('BOLETOSIMPLES_CLIENT_CREDENTIALS_TOKEN')
      ];
    }

    public function startTestSuite(TestSuite $suite): void {
      foreach($this->sensitiveData() as $k => $v) {
        if($v != null) {
          shell_exec("perl -e \"s/" . $k . "/" . $v . "/g;\" -pi $(find " . dirname (__FILE__) . "/../fixtures -type f)");
        }
      }
      $this->dataChanged = $this->sensitiveData();
    }

    public function endTestSuite(TestSuite $suite): void {
      foreach($this->dataChanged as $k => $v) {
        if($v != null) {
          shell_exec("perl -e \"s/" . $v . "/" . $k . "/g;\" -pi $(find " . dirname (__FILE__) . "/../fixtures -type f)");
        }
      }
    }
}