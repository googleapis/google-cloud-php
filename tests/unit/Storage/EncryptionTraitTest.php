<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Tests\Storage;

use Google\Cloud\Storage\EncryptionTrait;

/**
 * @group storage
 */
class EncryptionTraitTest extends \PHPUnit_Framework_TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getObjectForTrait(EncryptionTrait::class);
    }

    /**
     * @dataProvider encryptionProvider
     */
    public function testFormatEncryptionHeaders($expectedOptions, $options)
    {
        $this->assertEquals(
            $expectedOptions,
            $this->trait->formatEncryptionHeaders($options)
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFormatEncryptionHeadersThrowsExceptionWithoutBothKeyAndHash()
    {
        $this->trait->formatEncryptionHeaders([
            'encryptionKey' => 'abcd'
        ]);
    }

    public function encryptionProvider()
    {
        $key = 'abcd';
        $hash = '1234';
        $destinationKey = 'efgh';
        $destinationHash = '5678';

        return [
            [
                [
                    'httpOptions' => [
                        'headers' => $this->getEncryptionHeaders($key, $hash)
                    ]
                ],
                [
                    'encryptionKey' => $key,
                    'encryptionKeySHA256' => $hash
                ]
            ],
            [
                [
                    'httpOptions' => [
                        'headers' => array_merge(
                            $this->getEncryptionHeaders($destinationKey, $destinationHash),
                            $this->getCopySourceEncryptionHeaders($key, $hash)
                        )
                    ]
                ],
                [
                    'useCopySourceHeaders' => true,
                    'encryptionKey' => $key,
                    'encryptionKeySHA256' => $hash,
                    'destinationEncryptionKey' => $destinationKey,
                    'destinationEncryptionKeySHA256' => $destinationHash
                ]
            ],
            [
                [
                    'httpOptions' => [
                        'headers' => $this->getEncryptionHeaders($key, $hash) + ['hey' => 'dont clobber me']
                    ]
                ],
                [
                    'encryptionKey' => $key,
                    'encryptionKeySHA256' => $hash,
                    'httpOptions' => [
                        'headers' => [
                            'hey' => 'dont clobber me'
                        ]
                    ]
                ]
            ]
        ];
    }

    private function getEncryptionHeaders($key, $hash)
    {
        return [
            'x-goog-encryption-algorithm' => 'AES256',
            'x-goog-encryption-key' => base64_encode($key),
            'x-goog-encryption-key-sha256' => base64_encode($hash)
        ];
    }

    private function getCopySourceEncryptionHeaders($key, $hash)
    {
        return [
            'x-goog-copy-source-encryption-algorithm' => 'AES256',
            'x-goog-copy-source-encryption-key' => base64_encode($key),
            'x-goog-copy-source-encryption-key-sha256' => base64_encode($hash)
        ];
    }
}
