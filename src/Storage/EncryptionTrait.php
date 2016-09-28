<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage;

use InvalidArgumentException;

/**
 * Trait which provides helper methods for customer-supplied encryption.
 */
trait EncryptionTrait
{
    /**
     * @var array
     */
    private $copySourceEncryptionHeaderNames = [
        'algorithm' => 'x-goog-copy-source-encryption-algorithm',
        'key' => 'x-goog-copy-source-encryption-key',
        'keySHA256' => 'x-goog-copy-source-encryption-key-sha256'
    ];

    /**
     * @var array
     */
    private $encryptionHeaderNames = [
        'algorithm' => 'x-goog-encryption-algorithm',
        'key' => 'x-goog-encryption-key',
        'keySHA256' => 'x-goog-encryption-key-sha256'
    ];

    /**
     * Formats options for customer-supplied encryption headers.
     *
     * @param array $options
     * @return array
     * @throws \InvalidArgumentException
     * @access private
     */
    public function formatEncryptionHeaders(array $options)
    {
        $encryptionHeaders = [];
        $useCopySourceHeaders = isset($options['useCopySourceHeaders']) ? $options['useCopySourceHeaders'] : false;
        $key = isset($options['encryptionKey']) ? $options['encryptionKey'] : null;
        $keySHA256 = isset($options['encryptionKeySHA256']) ? $options['encryptionKeySHA256'] : null;
        $destinationKey = isset($options['destinationEncryptionKey']) ? $options['destinationEncryptionKey'] : null;
        $destinationKeySHA256 = isset($options['destinationEncryptionKeySHA256'])
            ? $options['destinationEncryptionKeySHA256']
            : null;

        unset($options['useCopySourceHeaders']);
        unset($options['encryptionKey']);
        unset($options['encryptionKeySHA256']);
        unset($options['destinationEncryptionKey']);
        unset($options['destinationEncryptionKeySHA256']);

        $encryptionHeaders = $this->buildHeaders($key, $keySHA256, $useCopySourceHeaders, false)
            + $this->buildHeaders($destinationKey, $destinationKeySHA256, false, true);

        if (!empty($encryptionHeaders)) {
            if (isset($options['httpOptions']['headers'])) {
                $options['httpOptions']['headers'] += $encryptionHeaders;
            } else {
                $options['httpOptions']['headers'] = $encryptionHeaders;
            }
        }

        return $options;
    }

    /**
     * Builds out customer-supplied encryption headers.
     *
     * @param string $key
     * @param string $keySHA256
     * @param bool $useCopySourceHeaders
     * @param bool $isDestination
     * @return array
     * @throws \InvalidArgumentException
     */
    private function buildHeaders($key, $keySHA256, $useCopySourceHeaders, $isDestination)
    {
        if ($key && $keySHA256) {
            $headerNames = $useCopySourceHeaders
                ? $this->copySourceEncryptionHeaderNames
                : $this->encryptionHeaderNames;

            return [
                $headerNames['algorithm'] => 'AES256',
                $headerNames['key'] => base64_encode($key),
                $headerNames['keySHA256'] => base64_encode($keySHA256)
            ];
        } elseif ($key || $keySHA256) {
            throw new \InvalidArgumentException(
                sprintf(
                    'When providing either %s or %s both must be supplied.',
                    $isDestination ? 'a destinationEncryptionKey' : 'an encryptionKey',
                    $isDestination ? 'a destinationEncryptionKeySHA256' : 'an encryptionKeySHA256'
                )
            );
        }

        return [];
    }
}
