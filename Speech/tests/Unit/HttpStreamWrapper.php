<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Speech\Tests\Unit;

class HttpStreamWrapper
{
    public $position = 0;
    public $bodyData = 'abcd';

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        return true;
    }

    public function stream_read($count)
    {
        $this->position += strlen($this->bodyData);
        if ($this->position > strlen($this->bodyData)) {
            return false;
        }

        return $this->bodyData;
    }

    public function stream_eof()
    {
        return $this->position >= strlen($this->bodyData);
    }

    public function stream_stat()
    {
        return [
            'wrapper_data' => ['test']
        ];
    }

    public function stream_tell()
    {
        return $this->position;
    }
}
