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

namespace Google\Cloud\Vision;

use Google\Cloud\Storage\Object;
use Guzzle\Stream\Stream;

class Image
{
    const TYPE_BYTES = 'bytes';
    const TYPE_STORAGE = 'storage';
    const TYPE_STRING = 'string';

    private $image;
    private $imageType;
    private $features;
    private $options;

    private $featureShortNames = [
        'faces'      => 'FACE_DETECTION',
        'landmarks'  => 'LANDMARK_DETECTION',
        'logos'      => 'LOGO_DETECTION',
        'labels'     => 'LABEL_DETECTION',
        'text'       => 'TEXT_DETECTION',
        'safeSearch' => 'SAFE_SEARCH_DETECTION',
        'properties' => 'IMAGE_PROPERTIES'
    ];

    /**
     * @param  mixed $image
     * @param  array $features
     * @param  array {
     *      Configuration options
     *
     *      @type array $context
     *      @type array $maxResults
     * }
     */
    public function __construct($image, array $features, array $options = [])
    {
        $this->options = $options + [
            'context' => [],
            'maxResults' => []
        ];

        $this->features = $this->normalizeFeatures($features);

        if ($image instanceof Object) {
            $identity = $image->identity();
            $uri = sprintf('gs://%s/%s', $identity['bucket'], $identity['object']);

            $this->imageType = self::TYPE_STORAGE;
            $this->image = $uri;
        } elseif (is_string($image)) {
            $this->imageType = self::TYPE_STRING;
            $this->image = $image;
        } else {
            $this->imageType = self::TYPE_BYTES;
            $this->image = new Stream($image);
        }
    }

    public function requestObject($encode = true)
    {
        return array_filter([
            'image' => $this->imageObject($encode),
            'features' => $this->features,
            'imageContext' => $this->options['context']
        ]);
    }

    private function imageObject($encode)
    {
        if ($this->imageType === self::TYPE_BYTES) {
            $bytes = (string) $this->image;

            return [
                'content' => ($encode) ? base64_encode($bytes) : $bytes
            ];
        }

        if ($this->imageType === self::TYPE_STRING) {
            $string = $this->image;

            return [
                'content' => ($encode) ? base64_encode($string) : $string
            ];
        }

        return [
            'source' => [
                'gcsImageUri' => $this->image
            ]
        ];
    }

    private function normalizeFeatures(array $features)
    {
        $result = [];

        foreach ($features as $key => $feature) {
            $maxResults = $this->maxResult($feature);

            if (array_key_exists($feature, $this->featureShortNames)) {
                $feature = $this->featureShortNames[$feature];
            }

            $result[] = array_filter([
                'type' => $feature,
                'maxResults' => $maxResults
            ]);
        }

        return $result;
    }

    private function maxResult($feature)
    {
        return (isset($this->options['maxResults'][$feature]))
            ? $this->options['maxResults'][$feature]
            : null;
    }
}
