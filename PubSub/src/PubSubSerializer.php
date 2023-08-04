<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\PubSub;

use Google\ApiCore\Serializer;
use Google\ApiCore\Traits\TimeTrait;
use Google\Cloud\Core\Duration as CoreDuration;

class PubSubSerializer extends Serializer
{
    use TimeTrait;

    public static $obj = null;

    public function __construct()
    {
        if(!is_null(self::$obj)){
            return self::$obj;
        }

        parent::__construct(
            $this->initFieldtransformers(),
            $this->initMessageTypeTransformers(),
            $this->initDecodeFieldTransformers(),
            $this->initDecodeMessageTypeTransformers()
        );

        self::$obj = $this;
    }

    private function initFieldtransformers() {
        return [
            'publish_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'expiration_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ];
    }

    private function initMessageTypeTransformers() {
        return [];
    }

    private function initDecodeFieldTransformers() {
        return [];
    }

    private function initDecodeMessageTypeTransformers() {
        return [
            'google.protobuf.Duration' => function ($v) {
                return $this->transformDuration($v);
            }
        ];
    }

    /**
     * Format a gRPC timestamp to match the format returned by the REST API.
     *
     * @param array $timestamp
     * @return string
     */
    private function formatTimestampFromApi(array $timestamp)
    {
        $timestamp += [
            'seconds' => 0,
            'nanos' => 0
        ];

        $dt = $this->createDateTimeFromSeconds($timestamp['seconds']);

        return $this->formatTimeAsString($dt, $timestamp['nanos']);
    }

    private function transformDuration($v)
    {
        if (is_string($v)) {
            $d = explode('.', trim($v, 's'));
            if (count($d) < 2) {
                $seconds = $d[0];
                $nanos = 0;
            } else {
                $seconds = (int) $d[0];
                $nanos = $this->convertFractionToNanoSeconds($d[1]);
            }
        } elseif ($v instanceof CoreDuration) {
            $d = $v->get();
            $seconds = $d['seconds'];
            $nanos = $d['nanos'];
        }

        return [
            'seconds' => $seconds,
            'nanos' => $nanos
        ];
    }
}
