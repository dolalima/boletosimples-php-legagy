<?php

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

\VCR\VCR::configure()
    ->setMode('once')
    ->enableLibraryHooks(['curl', 'stream_wrapper'])
    ->enableRequestMatchers(['method']);
\VCR\VCR::turnOn();