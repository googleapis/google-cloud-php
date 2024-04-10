<?php

namespace Google\ApiCore\LongRunning\Gapic;

if (false) {
    /**
     * This class is deprecated. Use Google\LongRunning\OperationsClient instead.
     * @deprecated
     */
    class OperationsGapicClient extends \Google\LongRunning\Client\OperationsClient
    {
    }
}
// Autoload the class and its alias
class_exists('\Google\LongRunning\Gapic\OperationsGapicClient');
@trigger_error(
    'Google\LongRunning\ApiCore\OperationsGapicClient is deprecated and will be removed in the next major release. Use Google\LongRunning\OperationsClient instead',
    E_USER_DEPRECATED
);
