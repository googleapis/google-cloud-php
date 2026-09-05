<?php

/**
 * Copyright 2026 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage\Connection;

use Google\Cloud\Core\RequestWrapper;
use Psr\Http\Message\RequestInterface;
use Ramsey\Uuid\Uuid;

/**
 * A wrapper for requests which adds an Idempotency Token.
 *
 * @internal
 */
class StorageRequestWrapper extends RequestWrapper
{
    /**
     * @param RequestInterface $request A PSR-7 request.
     * @param array $options [optional]
     * @return mixed
     */
    public function send(RequestInterface $request, array $options = [])
    {
        $options = $this->addToken($request, $options);
        return parent::send($request, $options);
    }

    /**
     * @param RequestInterface $request A PSR-7 request.
     * @param array $options [optional]
     * @return mixed
     */
    public function sendAsync(RequestInterface $request, array $options = [])
    {
        $options = $this->addToken($request, $options);
        return parent::sendAsync($request, $options);
    }

    /**
     * Helper to inject the token.
     *
     * @param RequestInterface $request
     * @param array $options
     * @return array
     */
    private function addToken(RequestInterface $request, array $options)
    {
        $method = strtoupper($request->getMethod());
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'])) {
            return $options;
        }

        $hasTokenInOptions = false;
        if (isset($options['restOptions']['headers'])) {
            foreach ($options['restOptions']['headers'] as $key => $value) {
                if (strtolower($key) === 'x-goog-gcs-idempotency-token') {
                    $hasTokenInOptions = true;
                    break;
                }
            }
        }

        if (!$hasTokenInOptions && !$request->hasHeader('x-goog-gcs-idempotency-token')) {
            $token = Uuid::uuid4()->toString();
            if (isset($options['retryHeaders'])) {
                foreach ($options['retryHeaders'] as $header) {
                    if (strpos($header, 'gccl-invocation-id/') === 0) {
                        $extractedToken = substr($header, 19);
                        if ($extractedToken !== false && $extractedToken !== '') {
                            $token = $extractedToken;
                        }
                        break;
                    }
                }
            }
            $options['restOptions']['headers']['x-goog-gcs-idempotency-token'] = $token;
        }
        return $options;
    }
}
