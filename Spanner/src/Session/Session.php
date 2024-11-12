<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Session;

use Google\ApiCore\ArrayTrait;
use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\RequestTrait;
use Google\Cloud\Spanner\V1\DeleteSessionRequest;
use Google\Cloud\Spanner\V1\GetSessionRequest;
use Google\Cloud\Spanner\V1\Client\SpannerClient;

/**
 * Represents and manages a single Cloud Spanner session.
 */
class Session
{
    use ApiHelperTrait;
    use ArrayTrait;
    use RequestTrait;

    /**
     * @var int|null
     */
    private $expiration;

    /**
     * @var bool
     */
    private $routeToLeader;

    /**
     * @internal Session is constructed by the {@see Database} class.
     *
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $projectId The project ID.
     * @param string $instance The instance name.
     * @param string $database The database name.
     * @param string $name The session name.
     * @param array $config [optional] {
     *     Configuration options.
     *
     *     @type bool $routeToLeader Enable/disable Leader Aware Routing.
     *         **Defaults to** `true` (enabled).
     * }
     */
    public function __construct(
        private SpannerClient $spannerClient,
        private Serializer $serializer,
        private $projectId,
        private $instance,
        private $database,
        private $name,
        $config = []
    ) {
        $this->databaseName = SpannerClient::databaseName(
            $projectId,
            $instance,
            $database
        );
        $this->name = SpannerClient::sessionName(
            $projectId,
            $instance,
            $database,
            $name
        );
        $this->routeToLeader = $this->pluck('routeToLeader', $config, false) ?? true;
    }

    /**
     * Return info on the session.
     *
     * @return array An array containing the `projectId`, `instance`, `database`, 'databaseName' and session `name`
     *         keys.
     */
    public function info()
    {
        return [
            'projectId' => $this->projectId,
            'instance' => $this->instance,
            'database' => $this->database,
            'databaseName' => $this->databaseName,
            'name' => $this->name
        ];
    }

    /**
     * Check if the session exists.
     *
     * @param array $options [optional] Configuration options.
     * @return bool
     */
    public function exists(array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data += [
            'name' => $this->name()
        ];

        try {
            $request = $this->serializer->decodeMessage(new GetSessionRequest(), $data);
            $callOptions = $this->addResourcePrefixHeader($callOptions, $this->databaseName);
            $callOptions = $this->addLarHeader($callOptions, $this->routeToLeader);

            $this->spannerClient->getSession($request, $callOptions);
        } catch (NotFoundException $e) {
            return false;
        }
        return true;
    }

    /**
     * Delete the session.
     *
     * @param array $options [optional] Configuration options.
     * @return void
     */
    public function delete(array $options = [])
    {
        list($data, $callOptions) = $this->splitOptionalArgs($options);
        $data = [
            'name' => $this->name()
        ];

        $request = $this->serializer->decodeMessage(new DeleteSessionRequest(), $data);
        $callOptions = $this->addResourcePrefixHeader($callOptions, $this->databaseName);

        $this->spannerClient->deleteSession($request, $callOptions);
    }

    /**
     * Format the constituent parts of a session name into a fully qualified session name.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Sets the expiration.
     *
     * @param int $expiration [optional] The Unix timestamp in seconds upon
     *        which the session will expire.  **Defaults to** now plus 60
     *        minutes.
     * @return void
     */
    public function setExpiration($expiration = null)
    {
        $this->expiration = $expiration ?: time() + SessionPoolInterface::SESSION_EXPIRATION_SECONDS;
    }

    /**
     * Gets the expiration.
     *
     * @return int|null
     */
    public function expiration()
    {
        return $this->expiration;
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'spannerClient' => get_class($this->spannerClient),
            'projectId' => $this->projectId,
            'instance' => $this->instance,
            'database' => $this->database,
            'databaseName' => $this->databaseName,
            'name' => $this->name,
        ];
    }
}
