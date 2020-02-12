<?php

namespace Google\Cloud\Spanner\Tests\Unit\GapicBackoff;

use \Google\ApiCore\OperationResponse;

class MockOperationResponse extends OperationResponse
{
    public $options;

    public function __construct ($operationName, $operationsClient, $options = []) {
        $this->options = $options;
        parent::__construct($operationName, $operationsClient, $options);
    }
}
