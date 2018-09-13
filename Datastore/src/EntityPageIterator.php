<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Datastore;

use Google\Cloud\Core\Iterator\PageIteratorTrait;

/**
 * Iterates over a set of pages containing {@see Google\Cloud\Datastore\Entity}
 * items.
 */
class EntityPageIterator implements \Iterator
{
    use PageIteratorTrait;

    /**
     * @var string|null
     */
    private $moreResultsType;

    /**
     * The state of the query after the current batch.
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/runQuery#MoreResultsType MoreResultsType Documentation
     * @codingStandardsIgnoreEnd
     *
     * @return string|null
     */
    public function moreResultsType()
    {
        return $this->moreResultsType;
    }

    /**
     * Get the current page.
     *
     * @return array|null
     */
    public function current()
    {
        if (!$this->page) {
            $this->page = $this->executeCall();
        }

        $this->moreResultsType = isset($this->page['batch']['moreResults'])
            ? $this->page['batch']['moreResults']
            : null;

        return $this->get($this->itemsPath, $this->page);
    }
}
