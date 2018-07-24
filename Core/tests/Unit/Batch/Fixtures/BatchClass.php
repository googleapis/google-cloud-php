<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Batch\Fixtures;

use Google\Cloud\Core\Batch\BatchTrait;
use Google\Cloud\Core\Tests\Unit\Batch\BatchTraitTest;

class BatchClass
{
    use BatchTrait {
        flush as publicFlush;
        send as publicSend;
        setCommonBatchProperties as privateSetCommonBatchProperties;
    }

    private $cb;

    public function __construct(array $options = [])
    {
        $options += [
            'batchRunner' => null,
            'identifier' => BatchTraitTest::ID,
            'batchMethod' => BatchTraitTest::BATCH_METHOD,
            'debugOutput' => false,
            'debugOutputResource' => null,
            'cb' => null
        ];

        $this->batchRunner = $options['batchRunner'];
        $this->identifier = $options['identifier'];
        $this->batchMethod = $options['batchMethod'];
        $this->debugOutput = $options['debugOutput'];
        $this->debugOutputResource = $options['debugOutputResource'];
        $this->cb = $options['cb'];
    }

    public function flush()
    {
        return $this->publicFlush();
    }

    public function send(array $items)
    {
        return $this->publicSend($items);
    }

    public function setCommonBatchProperties(array $options)
    {
        $this->privateSetCommonBatchProperties($options);
    }

    public function getCallback()
    {
        return $this->cb;
    }
}
