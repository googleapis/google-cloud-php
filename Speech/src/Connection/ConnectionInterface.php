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

namespace Google\Cloud\Speech\Connection;

/**
 * Represents a connection to
 * [Google Cloud Speech](https://cloud.google.com/speech/).
 *
 * @deprecated This class is no longer supported and will be removed in a future
 * release.
 */
interface ConnectionInterface
{
    /**
     * @param array $args
     * @return array
     */
    public function recognize(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function longRunningRecognize(array $args = []);

    /**
     * @param array $args
     * @return array
     */
    public function getOperation(array $args = []);
}
