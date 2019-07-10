<?php
/**
 * Copyright 2019 Google Inc.
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

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Storage\StorageClient;
use PHPUnit\Framework\TestCase;

/**
 * @group storage
 * @group storage-signed-url
 * @group storage-signed-url-conformance
 */
class SignedUrlConformanceTest extends TestCase
{
    const TESTDATA_PATH = 'conformance/v1';

    /**
     * @dataProvider signedUrlConformanceCases
     */
    public function testSignedUrlConformance(StorageClient $client, array $testdata)
    {
        $signingObject = $client->bucket($testdata['bucket']);
        if (isset($testdata['object']) && $testdata['object']) {
            $signingObject = $signingObject->object($testdata['object']);
        }

        $instanceMethodName = $testdata['method'] === 'POST'
            ? 'signedUploadUrl'
            : 'signedUrl';

        $generationTimestamp = \DateTimeImmutable::createFromFormat(
            \DateTimeInterface::RFC3339,
            $testdata['timestamp']
        );

        $testdata['timestamp'] = $generationTimestamp->format('Ymd\THis\Z');

        $expiration = $generationTimestamp->format('U') + $testdata['expiration'];

        $expectedUrl = $testdata['expectedUrl'];
        unset(
            $testdata['expectedUrl'],
            $testdata['bucket'],
            $testdata['object'],
            $testdata['expiration']
        );

        $signedUrl = $signingObject->$instanceMethodName($expiration, $testdata + [
            'version' => 'v4'
        ]);

        $this->assertEquals($expectedUrl, $signedUrl);
    }

    public function signedUrlConformanceCases()
    {
        $testDataPath = __DIR__ . '/' . self::TESTDATA_PATH . '/';
        $client = new StorageClient([
            'keyFilePath' => $testDataPath . 'service-account.json'
        ]);

        $cases = json_decode(file_get_contents($testDataPath . 'v4-signatures.json'), true);

        // rekey with description for more useful error reporting.
        $out = [];
        foreach ($cases['signingV4Tests'] as $key => $case) {
            $out[$case['description']] = [$client, $case];
            unset($case['description']);
        }

        return $out;
    }
}
