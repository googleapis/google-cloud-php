<?php
/*
 * Copyright 2025 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\Cloud\Firestore;

use Google\ApiCore\Serializer as ApiCoreSerializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\V1\PropertyFilter\Operator;
use Google\Protobuf\Int32Value;

class Serializer extends ApiCoreSerializer
{
    use ApiHelperTrait;
    private Serializer $serializer;

    public function __construct()
    {
        $fieldTransformers = [
            'commit_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'update_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'read_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ];
        $messageTypeTransformers = [
            // 'google.protobuf.Duration' => function ($v) {
            //     return $this->formatDurationFromApi($v);
            // }
        ];
        $decodeFieldTransformers = [
            'limit' => function ($v) {
                return new Int32Value(['value' => $v]);
            },
            // 'transaction' => function ($v) {
            //     return $v;
            // },
            // 'previous_transaction' => function ($v) {
            //     return base64_decode($v);
            // },
            // 'end_cursor' => function ($v) {
            //     return base64_decode($v);
            // },
            // 'start_cursor' => function ($v) {
            //     return base64_decode($v);
            // },
            // 'cursor' => function ($v) {
            //     return base64_decode($v);
            // },
            // 'timestamp_value' => function ($v) {
            //     return $this->formatTimestampForApi($v);
            // },
            // 'commit_time' => function ($v) {
            //     return 'AAA';
            // }
        ];
        $decodeMessageTypeTransformers = [
            'google.protobuf.Timestamp' => function ($v) {
                if ($v instanceof Timestamp) {
                    return $v->formatForApi();
                }

                return $v;
            },
            // 'google.datastore.v1.QueryResultBatch' => function ($v) {
            //     if (array_key_exists('entityResults', $v) && $v['entityResults'] === null) {
            //         $v['entityResults'] = [];
            //     }
            //     return $v;
            // },
            // 'google.datastore.v1.PropertyFilter' => function ($v) {
            //     if (array_key_exists('op', $v) && !filter_var($v['op'], FILTER_VALIDATE_INT)) {
            //         // convert from string to enum
            //         $v['op'] = Operator::value($v['op']);
            //     }
            //     return $v;
            // }
        ];

        parent::__construct(
            $fieldTransformers,
            $messageTypeTransformers,
            $decodeFieldTransformers,
            $decodeMessageTypeTransformers
        );
    }

    /**
     * Format a duration from the API
     *
     * @param array $value
     * @return string
     */
    private function formatDurationFromApi(array $value): string
    {
        $seconds = $value['seconds'];
        $nanos = str_pad($value['nanos'], 9, 0, STR_PAD_LEFT);

        return "{$seconds}.{$nanos}s";
    }
}
