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

/**
 * Represents a connection to
 * [Google Cloud Translation](https://cloud.google.com/translation/).
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     * @return array
     * @throws ServiceException
     */
    public function listDetections(array $args = []);

    /**
     * @param array $args
     * @return array
     * @throws ServiceException
     */
    public function listLanguages(array $args = []);

    /**
     * @param array $args
     * @return array
     * @throws ServiceException
     */
    public function listTranslations(array $args = []);
}
