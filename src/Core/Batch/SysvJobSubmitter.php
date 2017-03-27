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

namespace Google\Cloud\Core\Batch;

/**
 * JobSubmitInterface implementation with SysV IPC message queue.
 */
class SysvJobSubmitter implements JobSubmitInterface
{
    use SysvTrait;

    /* @var array */
    private $sysvQs;

    /**
     * Just initialize the internal array.
     */
    public function __construct()
    {
        $this->sysvQs = array();
    }

    /**
     * Submit an item for async processing.
     */
    public function submit($item, $idNum)
    {
        if (!array_key_exists($idNum, $this->sysvQs)) {
            $this->sysvQs[$idNum] =
                msg_get_queue($this->getSysvKey($idNum));
        }
        $result = @msg_send(
            $this->sysvQs[$idNum],
            self::$typeDirect,
            $item
        );
        if ($result === false) {
            // Try to put the content in a temp file and send the filename.
            $tempFile = tempnam(sys_get_temp_dir(), 'Item');
            $result = file_put_contents($tempFile, serialize($item));
            if ($result === false) {
                throw new \RuntimeException(
                    "Failed to write to $tempFile while submiting the item"
                );
            }
            $result = @msg_send(
                $this->sysvQs[$idNum],
                self::$typeFile,
                $tempFile
            );
            if ($result === false) {
                @unlink($tempFile);
                throw new \RuntimeException(
                    "Failed to submit the filename: $tempFile"
                );
            }
        }
    }
}
