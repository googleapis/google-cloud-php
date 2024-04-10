<?php

namespace Google\ApiCore\LongRunning;

use Google\ApiCore\LongRunning\Gapic\OperationsGapicClient;

if (false) {
    /**
     * This class is deprecated. Use Google\LongRunning\OperationsClient instead.
     * @deprecated
     */
    class OperationsClient extends OperationsGapicClient {}
}
// Autoload the class and its alias
class_exists('\Google\LongRunning\OperationsClient');
@trigger_error('Google\LongRunning\ApiCore\OperationsClient is deprecated and will be removed in the next major release. Use Google\LongRunning\OperationsClient instead', E_USER_DEPRECATED);

