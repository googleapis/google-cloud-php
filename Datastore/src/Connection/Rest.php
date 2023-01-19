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

namespace Google\Cloud\Datastore\Connection;

use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Core\Timestamp;

/**
 * Implementation of the
 * [Google Datastore JSON API](https://cloud.google.com/datastore/reference/rest/).
 */
class Rest implements ConnectionInterface
{
    use EmulatorTrait;
    use RestTrait;
    use UriTrait;

    const BASE_URI = 'https://datastore.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += ['emulatorHost' => null];

        $baseUri = $this->getApiEndpoint(self::BASE_URI, $config);
        if ((bool) $config['emulatorHost']) {
            // @codeCoverageIgnoreStart
            $baseUri = $this->emulatorBaseUri($config['emulatorHost']);
            $config['shouldSignRequest'] = false;
            // @codeCoverageIgnoreEnd
        }

        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/datastore-v1.json',
            'componentVersion' => DatastoreClient::VERSION
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $baseUri
        ));
    }

    /**
     * @param array $args
     */
    public function allocateIds(array $args)
    {
        return $this->send('projects', 'allocateIds', $args);
    }

    /**
     * @param array $args
     */
    public function beginTransaction(array $args)
    {
        $argsWithReadTime = $this->setReadTime($args);
        return $this->send('projects', 'beginTransaction', $argsWithReadTime);
    }

    /**
     * @param array $args
     */
    public function commit(array $args)
    {
        return $this->send('projects', 'commit', $args);
    }

    /**
     * @param array $args
     */
    public function lookup(array $args)
    {
        $argsWithReadTime = $this->setReadTime($args);
        return $this->send('projects', 'lookup', $argsWithReadTime);
    }

    /**
     * @param array $args
     */
    public function rollback(array $args)
    {
        return $this->send('projects', 'rollback', $args);
    }

    /**
     * @param array $args
     */
    public function runQuery(array $args)
    {
        $argsWithReadTime = $this->setReadTime($args);
        return $this->send('projects', 'runQuery', $argsWithReadTime);
    }

    /**
     * @param array $args
     */
    private function setReadTime(array $args)
    {
        if (isset($args['readOptions']['readTime'])) {
            $this->setReadTimeOption($args['readOptions']['readTime']);
        } elseif (isset($args['transactionOptions']['readOnly']['readTime'])) {
            $this->setReadTimeOption($args['transactionOptions']['readOnly']['readTime']);
        }
        return $args;
    }

    /**
     * @param timestamp $readTime
     */
    private function setReadTimeOption(&$readTime)
    {
        $date = date('Y/m/d H:i:s.u\Z', $readTime->getSeconds());
        $readTime = new Timestamp(new \DateTime($date));
    }
}
