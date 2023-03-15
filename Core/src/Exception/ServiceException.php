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

/**
 * Exception thrown when a request fails.
 */
class ServiceException extends GoogleException
{
    // This is the value of the '@type' key for an ErrorInfo object returned
    // in the exception response
    const ERRORINFO_TYPE_REST = 'type.googleapis.com/google.rpc.ErrorInfo';

    /**
     * @var Exception|null
     */
    private $serviceException;

    /**
     * @var array
     */
    protected $metadata;

    /**
     * @var array|null
     */
    private $errorInfo;

    /**
     * @var array|null
     */
    private $errorInfoMetadata;

    /**
     * @var string|null
     */
    private $errorReason;

    /**
     * Handle previous exceptions differently here.
     *
     * @param string|null $message
     * @param int $code
     * @param Exception|null $serviceException
     * @param array $metadata [optional] Exception metadata.
     */
    public function __construct(
        $message = null,
        $code = 0,
        Exception $serviceException = null,
        array $metadata = []
    ) {
        $this->serviceException = $serviceException;
        $this->metadata = $metadata;
        $this->errorInfo = null;
        $this->errorInfoMetadata = null;
        $this->errorReason = null;

        parent::__construct($message ?: '', $code);
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
     * @return Exception|null
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
        // Only calc the metadata if we haven't cached it
        if (is_null($this->errorInfoMetadata)) {
            // For response originated from the GAPIC layer, the current exception would have
            // an ApiException within itself
            if ($this->getServiceException() instanceof ApiException) {
                return $this->getServiceException()->getErrorInfoMetadata();
            }

            $errorInfo = $this->getErrorInfoFromRestException();

            // Cache the result to be reused if needed
            $this->errorInfoMetadata = isset($errorInfo['metadata']) ? $errorInfo['metadata'] : [];
        }

        return $this->errorInfoMetadata;
    }

    /**
     * Returns the reason from the ErrorInfo part of the exception
     *
     * @return string
     */
    public function getReason()
    {
        // Only calc the errorReason if we haven't cached it
        if (is_null($this->errorReason)) {
            // For a response originated from the GAPIC layer, the current exception would have
            // an ApiException within itself
            if ($this->getServiceException() instanceof ApiException) {
                return $this->getServiceException()->getReason();
            }

            $errorInfo = $this->getErrorInfoFromRestException();

            // Cache the result to be reused if needed
            $this->errorReason = isset($errorInfo['reason']) ? $errorInfo['reason'] : '';
        }

        return $this->errorReason;
    }

    /**
     * Return the delay in seconds and nanos before retrying the failed request.
     *
     * @return array
     */
    public function getRetryDelay()
    {
        $metadata = array_filter($this->metadata, function ($metadataItem) {
            return array_key_exists('retryDelay', $metadataItem);
        });

        if (count($metadata) === 0) {
            return ['seconds' => 0, 'nanos' => 0];
        }

        return $metadata[0]['retryDelay'] + [
            'seconds' => 0,
            'nanos' => 0
        ];
    }

    /**
     * Helper to return the error info from an exception
     * which is not raised from the GAPIC layer
     *
     * @return array
     */
    private function getErrorInfoFromRestException()
    {
        // Only calc errorInfo if it isn't cached
        if (is_null($this->errorInfo)) {
            $this->errorInfo = [];
            $arr = json_decode($this->getMessage(), true);

            if (!isset($arr['error']['details'])) {
                return $this->errorInfo;
            }

            foreach ($arr['error']['details'] as $row) {
                if (isset($row['@type']) && $row['@type'] === self::ERRORINFO_TYPE_REST) {
                    // save this in cache
                    $this->errorInfo = $row;
                    break;
                }
            }
        }

        return $this->errorInfo;
    }
}
