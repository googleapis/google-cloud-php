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

namespace Google\Cloud\Language\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Language\LanguageClient;

/**
 * Implementation of the
 * [Google Natural Language JSON API](https://cloud.google.com/natural-language/reference/rest/).
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use UriTrait;

    const BASE_URI = 'https://language.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/language-v1.json',
            'componentVersion' => LanguageClient::VERSION
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            self::BASE_URI
        ));
    }

    /**
     * @param array $args
     * @return array
     */
    public function analyzeEntities(array $args = [])
    {
        return $this->send('documents', 'analyzeEntities', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function analyzeSentiment(array $args = [])
    {
        return $this->send('documents', 'analyzeSentiment', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function analyzeEntitySentiment(array $args = [])
    {
        return $this->send('documents', 'analyzeEntitySentiment', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function analyzeSyntax(array $args = [])
    {
        return $this->send('documents', 'analyzeSyntax', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function annotateText(array $args = [])
    {
        return $this->send('documents', 'annotateText', $args);
    }

    /**
     * @param array $args
     * @return array
     */
    public function classifyText(array $args = [])
    {
        return $this->send('documents', 'classifyText', $args);
    }
}
