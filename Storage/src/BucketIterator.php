<?php
/**
 * Copyright 2025 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage;

use ArrayObject;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;

/**
 * Iterates over a set of buckets.
 *
 * Use the `unreachable()` method to get a list of bucket names that could not
 * be retrieved. This is only populated when the `returnPartialSuccess` is set to true
 */
class BucketIterator extends ItemIterator
{
    /**
     * @param PageIterator $iterator
     * @param ArrayObject $unreachable
     */
    public function __construct(PageIterator $iterator, private ArrayObject $unreachable)
    {
        parent::__construct($iterator);
    }

    /**
     * Get the list of unreachable buckets.
     *
     * @return array<string>
     */
    public function unreachable()
    {
        return $this->unreachable->getArrayCopy();
    }
}
