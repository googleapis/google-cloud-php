<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Translate\V2\Connection;

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Translate\V2\TranslateClient;

/**
 * Implementation of the
 * [Google Cloud Translation REST API](https://cloud.google.com/translation/docs/how-to).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use UriTrait;

    /**
     * @deprecated
     */
    const BASE_URI = 'https://translation.googleapis.com/language/translate/';

    const DEFAULT_API_ENDPOINT = 'https://translation.googleapis.com';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/translate-v2.json',
            'componentVersion' => TranslateClient::VERSION
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $this->getApiEndpoint(self::DEFAULT_API_ENDPOINT, $config)
        ));
    }

    /**
     * @param array $args
     * @return array
     * @throws ServiceException
     */
    public function listDetections(array $args = [])
    {
        return $this->send('detections', 'detect', $args);
    }

    /**
     * @param array $args
     * @return array
     * @throws ServiceException
     */
    public function listLanguages(array $args = [])
    {
        return $this->send('languages', 'list', $args);
    }

    /**
     * @param array $args
     * @return array
     * @throws ServiceException
     */
    public function listTranslations(array $args = [])
    {
        return $this->send('translations', 'translate', $args);
    }
}

//@codingStandardsIgnoreStart
// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Rest::class, \Google\Cloud\Translate\Connection\Rest::class);
//@codingStandardsIgnoreEnd
