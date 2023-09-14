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

namespace Google\Cloud\Vision\Connection;

use Google\Cloud\Core\RequestBuilder;
use Google\Cloud\Core\RequestWrapper;
use Google\Cloud\Core\RestTrait;
use Google\Cloud\Core\UriTrait;
use Google\Cloud\Vision\VisionClient;

/**
 * Implementation of the
 * [Google Cloud Vision JSON API](https://cloud.google.com/vision/reference/rest/).
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
class Rest implements ConnectionInterface
{
    use RestTrait;
    use UriTrait;

    const BASE_URI = 'https://vision.googleapis.com/';

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config += [
            'serviceDefinitionPath' => __DIR__ . '/ServiceDefinition/vision-v1.json',
            'componentVersion' => VisionClient::VERSION
        ];

        $this->setRequestWrapper(new RequestWrapper($config));
        $this->setRequestBuilder(new RequestBuilder(
            $config['serviceDefinitionPath'],
            $this->getApiEndpoint(self::BASE_URI, $config)
        ));

        $class = get_class($this);
        $err = "The class {$class} is no longer supported";
        @trigger_error($err, E_USER_DEPRECATED);
    }

    /**
     * @param array $args
     */
    public function annotate(array $args)
    {
        return $this->send('images', 'annotate', $args);
    }
}
