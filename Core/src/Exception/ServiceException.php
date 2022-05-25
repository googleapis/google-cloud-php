<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Core\Exception;

use Exception;
use Google\ApiCore\ApiException;

// This is the value of the '@type' key for an ErrorInfo object returned
// in the exception response
const ERRORINFO_TYPE_REST = 'type.googleapis.com/google.rpc.ErrorInfo';

/**
 * Exception thrown when a request fails.
 */
class ServiceException extends GoogleException
{
    /**
     * @var Exception
     */
    private $serviceException;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * Handle previous exceptions differently here.
     *
     * @param string $message
     * @param int $code
     * @param Exception $serviceException
     * @param array $metadata [optional] Exception metadata.
     */
    public function __construct(
        $message,
        $code = null,
        Exception $serviceException = null,
        array $metadata = []
    ) {
        $this->serviceException = $serviceException;
        $this->metadata = $metadata;

        parent::__construct($message, $code);
    }

    /**
     * If $serviceException is set, return true.
     *
     * @return bool
     */
    public function hasServiceException()
    {
        return (bool) $this->serviceException;
    }

    /**
     * Return the service exception object.
     *
     * @return Exception
     */
    public function getServiceException()
    {
        return $this->serviceException;
    }

    /**
     * Get exception metadata.
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Returns the metadata from the ErrorInfo part of the exception
     *
     * @return array
     */
    public function getErrorInfoMetadata()
    {
        // For response originated from the GAPIC layer, the current exception would have
        // an ApiException within itself
        if ($this->getServiceException() instanceof ApiException) {
            return $this->getServiceException()->getErrorInfoMetadata();
        }

        $errorInfo = $this->getErrorInfoFromRestException();

        return isset($errorInfo['metadata']) ? $errorInfo['metadata'] : [];
    }

    /**
     * Returns the reason from the ErrorInfo part of the exception
     *
     * @return string
     */
    public function getReason()
    {
        // For response originated from the GAPIC layer, the current exception would have
        // an ApiException within itself
        if ($this->getServiceException() instanceof ApiException) {
            return $this->getServiceException()->getReason();
        }

        $errorInfo = $this->getErrorInfoFromRestException();

        return isset($errorInfo['reason']) ? $errorInfo['reason'] : '';
    }


    /**
     * Helper to return the error info from an exception
     * which is not raised from the GAPIC layer
     *
     * @return array
     */
    private function getErrorInfoFromRestException()
    {
        $arr = json_decode($this->getMessage(), true);

        if (!isset($arr['error']['details'])) {
            return [];
        }
        
        $details = $arr['error']['details'];

        foreach ($details as $row) {
            if (isset($row['@type']) && $row['@type'] === ERRORINFO_TYPE_REST) {
                return $row;
            }
        }

        return [];
    }
}
