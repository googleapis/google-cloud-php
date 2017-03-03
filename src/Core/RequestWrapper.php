<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core;

use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\Core\Exception;
use Google\Cloud\Core\RequestWrapperTrait;
use Google\Cloud\ServiceBuilder;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * The RequestWrapper is responsible for delivering and signing requests.
 */
class RequestWrapper
{
    use RequestWrapperTrait;

    /**
     * @var string
     */
    private $componentVersion;

    /**
     * @var string Access token used to sign requests.
     */
    private $accessToken;

    /**
     * @var callable A handler used to deliver Psr7 requests specifically for
     * authentication.
     */
    private $authHttpHandler;

    /**
     * @var callable A handler used to deliver Psr7 requests.
     */
    private $httpHandler;

    /**
     * @var array HTTP client specific configuration options.
     */
    private $httpOptions;

    /**
     * @var array
     */
    private $httpRetryCodes = [
        500,
        502,
        503
    ];

    /**
     * @var array
     */
    private $httpRetryMessages = [
        'rateLimitExceeded',
        'userRateLimitExceeded'
    ];

    /**
     * @var bool $shouldSignRequest Whether to enable request signing.
     */
    private $shouldSignRequest;

    /**
     * @param array $config [optional] {
     *     Configuration options. Please see
     *     {@see Google\Cloud\RequestWrapperTrait::setCommonDefaults()} for the other
     *     available options.
     *
     *     @type string $componentName The name of the component from which the request
     *           originated.
     *     @type string $componentVersion The current version of the component from
     *           which the request originated.
     *     @type string $accessToken Access token used to sign requests.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type array $httpOptions HTTP client specific configuration options.
     *     @type bool $shouldSignRequest Whether to enable request signing.
     * }
     */
    public function __construct(array $config = [])
    {
        $this->setCommonDefaults($config);
        $config += [
            'accessToken' => null,
            'authHttpHandler' => null,
            'httpHandler' => null,
            'httpOptions' => [],
            'shouldSignRequest' => true,
            'componentVersion' => null
        ];

        $this->componentVersion = $config['componentVersion'];
        $this->accessToken = $config['accessToken'];
        $this->httpHandler = $config['httpHandler'] ?: HttpHandlerFactory::build();
        $this->authHttpHandler = $config['authHttpHandler'] ?: $this->httpHandler;
        $this->httpOptions = $config['httpOptions'];
        $this->shouldSignRequest = $config['shouldSignRequest'];
    }

    /**
     * Deliver the request.
     *
     * @param RequestInterface $request Psr7 request.
     * @param array $options [optional] {
     *     Request options.
     *
     *     @type int $retries Number of retries for a failed request.
     *           **Defaults to** `3`.
     *     @type array $httpOptions HTTP client specific configuration options.
     * }
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        $retries = isset($options['retries']) ? $options['retries'] : $this->retries;
        $httpOptions = isset($options['httpOptions']) ? $options['httpOptions'] : $this->httpOptions;
        $backoff = new ExponentialBackoff($retries, $this->getRetryFunction());

        $signedRequest = $this->shouldSignRequest ? $this->signRequest($request) : $request;

        try {
            return $backoff->execute($this->httpHandler, [$signedRequest, $httpOptions]);
        } catch (\Exception $ex) {
            throw $this->convertToGoogleException($ex);
        }
    }

    /**
     * Sign the request.
     *
     * @param RequestInterface $request Psr7 request.
     * @return RequestInterface
     */
    private function signRequest(RequestInterface $request)
    {
        $uaTemplate = 'gcloud-php-%s/%s';
        $headers = [
            'User-Agent' => sprintf($uaTemplate, '', $this->componentVersion),
            'Authorization' => 'Bearer ' . $this->getToken()
        ];

        return Psr7\modify_request($request, ['set_headers' => $headers]);
    }

    /**
     * Gets the access token.
     *
     * @return string
     */
    private function getToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        return $this->fetchCredentials()['access_token'];
    }

    /**
     * Fetches credentials.
     *
     * @return array
     */
    private function fetchCredentials()
    {
        $backoff = new ExponentialBackoff($this->retries, $this->getRetryFunction());

        try {
            return $backoff->execute(
                [$this->getCredentialsFetcher(), 'fetchAuthToken'],
                [$this->authHttpHandler]
            );
        } catch (\Exception $ex) {
            throw $this->convertToGoogleException($ex);
        }
    }

    /**
     * Convert any exception to a Google Exception.
     *
     * @param  \Exception $ex
     * @return  ServiceException
     */
    private function convertToGoogleException(\Exception $ex)
    {
        switch ($ex->getCode()) {
            case 400:
                $exception = Exception\BadRequestException::class;
                break;

            case 404:
                $exception = Exception\NotFoundException::class;
                break;

            case 409:
                $exception = Exception\ConflictException::class;
                break;

            case 500:
                $exception = Exception\ServerException::class;
                break;

            default:
                $exception = Exception\ServiceException::class;
                break;
        }

        return new $exception($this->getExceptionMessage($ex), $ex->getCode(), $ex);
    }

    /**
     * Gets the exception message.
     *
     * @param \Exception $ex
     * @return string
     */
    private function getExceptionMessage(\Exception $ex)
    {
        if ($ex instanceof RequestException && $ex->hasResponse()) {
            $res = (string) $ex->getResponse()->getBody();
            json_decode($res);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $res;
            }
        }

        return $ex->getMessage();
    }

    /**
     * Determines whether or not the request should be retried.
     *
     * @return bool
     */
    private function getRetryFunction()
    {
        $httpRetryCodes = $this->httpRetryCodes;
        $httpRetryMessages = $this->httpRetryMessages;

        return function (\Exception $ex) use ($httpRetryCodes, $httpRetryMessages) {
            $statusCode = $ex->getCode();

            if (in_array($statusCode, $httpRetryCodes)) {
                return true;
            }

            $message = json_decode($ex->getMessage(), true);

            if (!isset($message['error']['errors'])) {
                return false;
            }

            foreach ($message['error']['errors'] as $error) {
                if (in_array($error['reason'], $httpRetryMessages)) {
                    return true;
                }
            }

            return false;
        };
    }
}
