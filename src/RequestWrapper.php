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

namespace Google\Cloud;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Cloud\Exception;
use GuzzleHttp\Psr7;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * The RequestWrapper is responsible for delivering and signing requests.
 */
class RequestWrapper
{
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
     * @var array Credentials used to sign requests.
     */
    private $credentials;

    /**
     * @var FetchAuthTokenInterface Fetches credentials.
     */
    private $credentialsFetcher;

    /**
     * @var callable A handler used to deliver Psr7 requests.
     */
    private $httpHandler;

    /**
     * @var callable HTTP client specific configuration options.
     */
    private $httpOptions;

    /**
     * @var array The contents of the service account
     * credentials .json file retrieved from the Google Developers Console.
     */
    private $keyFile;

    /**
     * @var int Number of retries for a failed request. Defaults to 3.
     */

    private $retries;
    /**
     * @var array
     */
    private $httpRetryCodes = [
        500,
        502,
        503,
        504
    ];

    /**
     * @var array
     */
    private $httpRetryMessages = [
        'rateLimitExceeded',
        'userRateLimitExceeded'
    ];

    /**
     * @var array Scopes to be used for the request.
     */
    private $scopes = [];

    /**
     * @var boolean $shouldSignRequest Whether to enable request signing.
     */
    private $shouldSignRequest;

    /**
     * @param array $options {
     *     Configuration options.
     *
     *     @type string $accessToken Access token used to sign requests.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type array $httpOptions HTTP client specific configuration options.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     *     @type boolean $shouldSignRequest Whether to enable request signing.
     * }
     */
    public function __construct(array $config = [])
    {
        $config += [
            'accessToken' => null,
            'authHttpHandler' => null,
            'credentialsFetcher' => null,
            'httpHandler' => null,
            'httpOptions' => [],
            'keyFile' => null,
            'retries' => null,
            'scopes' => null,
            'shouldSignRequest' => true
        ];

        if ($config['credentialsFetcher'] && !$config['credentialsFetcher'] instanceof FetchAuthTokenInterface) {
            throw new \InvalidArgumentException('credentialsFetcher must implement FetchAuthTokenInterface.');
        }

        $this->accessToken = $config['accessToken'];
        $this->credentialsFetcher = $config['credentialsFetcher'];
        $this->httpHandler = $config['httpHandler'] ?: HttpHandlerFactory::build();
        $this->authHttpHandler = $config['authHttpHandler'] ?: $this->httpHandler;
        $this->httpOptions = $config['httpOptions'];
        $this->retries = $config['retries'];
        $this->scopes = $config['scopes'];
        $this->keyFile = $config['keyFile'];
        $this->shouldSignRequest = $config['shouldSignRequest'];
    }

    /**
     * Deliver the request.
     *
     * @param RequestInterface $request Psr7 request.
     * @param array $options {
     *     Request options.
     *
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
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
     * Gets the credentials fetcher. Precedence begins with user supplied
     * credentials fetcher instance, followed by a reference to a key file
     * stream, and finally the application default credentials.
     *
     * @return FetchAuthTokenInterface
     */
    public function getCredentialsFetcher()
    {
        if ($this->credentialsFetcher) {
            return $this->credentialsFetcher;
        }

        if ($this->keyFile) {
            return CredentialsLoader::makeCredentials($this->scopes, $this->keyFile);
        }

        return ApplicationDefaultCredentials::getCredentials($this->scopes, $this->authHttpHandler);
    }

    /**
     * Sign the request.
     *
     * @param RequestInterface $request Psr7 request.
     * @return RequestInterface
     */
    private function signRequest(RequestInterface $request)
    {
        $headers = [
            'User-Agent' => 'gcloud-php/' . ServiceBuilder::VERSION,
            'Authorization' => 'Bearer ' . $this->getToken()
        ];

        return Psr7\modify_request($request, ['set_headers' => $headers]);
    }

    /**
     * Gets the access token.
     *
     * @return string
     * @todo Investigate refreshing tokens
     */
    private function getToken()
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        if (!$this->credentials || $this->credentials['expiry'] < time()) {
            $this->credentials = $this->fetchCredentials();
        }

        return $this->credentials['access_token'];
    }

    /**
     * Fetches credentials.
     *
     * @return array
     */
    private function fetchCredentials()
    {
        try {
            $credentials = $this->getCredentialsFetcher()->fetchAuthToken($this->authHttpHandler);
        } catch (\Exception $ex) {
            throw $this->convertToGoogleException($ex);
        }

        $credentials['expiry'] = time() + $this->credentials['expires_in'];

        return $credentials;
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

        return new $exception($ex->getMessage(), $ex->getCode(), $ex);
    }



    /**
     * Determines whether or not the request should be retried.
     *
     * @param \Exception $ex
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
