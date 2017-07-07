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

namespace Google\Cloud\Tests\Unit\Storage;

use Google\Cloud\Tests\KeyPairGenerateTrait;
use Google\Cloud\Storage\EncryptionTrait;

/**
 * @group storage
 */
class EncryptionTraitTest extends \PHPUnit_Framework_TestCase
{
    use KeyPairGenerateTrait;

    private $implementation;

    public function setUp()
    {
        $this->implementation = \Google\Cloud\Dev\impl(EncryptionTrait::class);
    }

    public function testSignString()
    {
        $testString = 'hello world';

        list($pkey, $pub) = $this->getKeyPair();

        $res = $this->implementation->call('signString', [$pkey, $testString]);

        $this->assertTrue($this->verifySignature($pkey, $testString, urlencode(base64_encode($res))));
    }

    public function testSignStringWithOpenSsl()
    {
        $testString = 'hello world';

        list($pkey, $pub) = $this->getKeyPair();

        $res = $this->implementation->call('signString', [$pkey, $testString, true]);

        $this->assertTrue($this->verifySignature($pkey, $testString, urlencode(base64_encode($res))));
    }

    /**
     * @dataProvider encryptionProvider
     */
    public function testFormatEncryptionHeaders($expectedOptions, $options)
    {
        $this->assertEquals(
            $expectedOptions,
            $this->implementation->formatEncryptionHeaders($options)
        );
    }

    public function encryptionProvider()
    {
        $key = base64_encode('abcd');
        $hash = base64_encode(hash('SHA256', base64_decode($key), true));
        $destinationKey = base64_encode('efgh');
        $destinationHash = base64_encode(hash('SHA256', base64_decode($destinationKey), true));

        return [
            [
                [
                    'restOptions' => [
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
                    'restOptions' => [
                        'headers' => $this->getEncryptionHeaders($key, $hash)
                    ]
                ],
                [
                    'encryptionKey' => $key
                ]
            ],
            [
                [
                    'restOptions' => [
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
                    'restOptions' => [
                        'headers' => $this->getEncryptionHeaders($key, $hash) + ['hey' => 'dont clobber me']
                    ]
                ],
                [
                    'encryptionKey' => $key,
                    'encryptionKeySHA256' => $hash,
                    'restOptions' => [
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
            'x-goog-encryption-key' => $key,
            'x-goog-encryption-key-sha256' => $hash
        ];
    }

    private function getCopySourceEncryptionHeaders($key, $hash)
    {
        return [
            'x-goog-copy-source-encryption-algorithm' => 'AES256',
            'x-goog-copy-source-encryption-key' => $key,
            'x-goog-copy-source-encryption-key-sha256' => $hash
        ];
    }
}
