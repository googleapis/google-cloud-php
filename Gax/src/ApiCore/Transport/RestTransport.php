<?php
/*
 * Copyright 2018, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore\Transport;

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\Call;
use Google\ApiCore\RequestBuilder;
use Google\Auth\FetchAuthTokenInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

/**
 * A REST based transport implementation.
 */
class RestTransport implements TransportInterface
{
    private $authHttpHandler;
    private $credentialsLoader;
    private $httpHandler;
    private $requestBuilder;

    /**
     * @param RequestBuilder $requestBuilder A builder responsible for creating
     *        a PSR-7 request from a set of request information.
     * @param FetchAuthTokenInterface $credentialsLoader A credentials loader
     *        used to fetch access tokens.
     * @param callable $httpHandler A handler used to deliver PSR-7 requests.
     * @param callable $authHttpHandler A handler used to deliver PSR-7 requests
     *        specifically for authentication. Should match a signature of
     *        `function (RequestInterface $request, array $options) : ResponseInterface`.
     */
    public function __construct(
        RequestBuilder $requestBuilder,
        FetchAuthTokenInterface $credentialsLoader,
        callable $httpHandler,
        callable $authHttpHandler
    ) {
        $this->requestBuilder = $requestBuilder;
        $this->credentialsLoader = $credentialsLoader;
        $this->httpHandler = $httpHandler;
        $this->authHttpHandler = $authHttpHandler;
    }

    /**
     * {@inheritdoc}
     * @throws \BadMethodCallException
     */
    public function startClientStreamingCall(Call $call, array $options)
    {
        $this->throwUnsupportedException();
    }

    /**
     * {@inheritdoc}
     * @throws \BadMethodCallException
     */
    public function startServerStreamingCall(Call $call, array $options)
    {
        $this->throwUnsupportedException();
    }

    /**
     * {@inheritdoc}
     * @throws \BadMethodCallException
     */
    public function startBidiStreamingCall(Call $call, array $options)
    {
        $this->throwUnsupportedException();
    }

    /**
     * {@inheritdoc}
     */
    public function startUnaryCall(Call $call, array $options)
    {
        $headers = isset($options['headers'])
            ? $options['headers']
            : [];

        // If not already set, add an auth header to the request
        if (!isset($headers['Authorization'])) {
            $token = $this->credentialsLoader->fetchAuthToken($this->authHttpHandler)['access_token'];
            $headers['Authorization'] = 'Bearer ' . $token;
        }

        // call the HTTP handler
        $httpHandler = $this->httpHandler;
        return $httpHandler(
            $this->requestBuilder->build(
                $call->getMethod(),
                $call->getMessage(),
                $headers
            ),
            $this->getCallOptions($options)
        )->then(
            function (ResponseInterface $response) use ($call) {
                $decodeType = $call->getDecodeType();
                $return = new $decodeType;
                $return->mergeFromJsonString(
                    (string) $response->getBody()
                );

                return $return;
            },
            function (\Exception $ex) {
                if ($ex instanceof RequestException && $ex->hasResponse()) {
                    throw $this->convertToApiException($ex);
                }

                throw $ex;
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        // Nothing to do.
    }

    private function throwUnsupportedException()
    {
        throw new \BadMethodCallException('Streaming calls are not supported while using the REST transport.');
    }

    private function getCallOptions(array $options)
    {
        $callOptions = isset($options['transportOptions']['restOptions'])
            ? $options['transportOptions']['restOptions']
            : [];

        if (isset($options['timeoutMillis'])) {
            $callOptions['timeout'] = $options['timeoutMillis'] / 1000;
        }

        return $callOptions;
    }

    private function convertToApiException(\Exception $ex)
    {
        $res = (string) $ex->getResponse()->getBody();
        $rObj = (object) json_decode($res, true)['error'];
        // Overwrite the HTTP Status Code with the RPC code, derived from the "status" field.
        $rObj->code = ApiStatus::rpcCodeFromStatus($rObj->status);
        $rObj->metadata = property_exists($rObj, 'details') ? $rObj->details : null;
        $rObj->details = $rObj->message;

        return ApiException::createFromStdClass($rObj);
    }
}
