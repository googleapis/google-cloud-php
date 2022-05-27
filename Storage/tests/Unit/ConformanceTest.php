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
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group storage
 * @group storage-conformance
 */
class ConformanceTest extends TestCase
{
    private static $cases;

    public static function set_up_before_class()
    {
        static $setup = false;
        if ($setup) {
            return;
        }

        $setup = true;
        self::$cases = json_decode(file_get_contents(__DIR__ . '/data/signed-url-v4-testdata.json'), true);
    }

    /**
     * @group storage-conformance-signed-url
     * @dataProvider signedUrlConformanceCases
     */
    public function testSignedUrlConformance(array $testdata)
    {
        $client = new StorageClient([
            'keyFilePath' => __DIR__ . '/data/signed-url-v4-service-account.json'
        ]);

        $signingObject = $client->bucket($testdata['bucket']);
        if (isset($testdata['object']) && $testdata['object']) {
            $signingObject = $signingObject->object($testdata['object']);
        }

        if (isset($testdata['queryParameters'])) {
            $testdata['queryParams'] = $testdata['queryParameters'];
        }

        $hostnameOptions = $this->getHostnameOptions($testdata);

        $instanceMethodName = $testdata['method'] === 'POST'
            ? 'signedUploadUrl'
            : 'signedUrl';

        $generationTimestamp = \DateTimeImmutable::createFromFormat(\DateTime::RFC3339, $testdata['timestamp']);
        $expiration = $generationTimestamp->format('U') + $testdata['expiration'];

        $expectedUrl = $testdata['expectedUrl'];
        unset(
            $testdata['expectedUrl'],
            $testdata['bucket'],
            $testdata['object'],
            $testdata['expiration'],
            $testdata['queryParameters'],
            $testdata['urlStyle'],
            $testdata['bucketBoundDomain']
        );

        $signedUrl = $signingObject->$instanceMethodName($expiration, $hostnameOptions + $testdata + [
            'version' => 'v4'
        ]);

        $this->assertEquals($expectedUrl, $signedUrl);
    }

    /**
     * @group storage-conformance-post-policy
     * @dataProvider postPolicyConformanceCases
     */
    public function testPostPolicy(array $testdata)
    {
        $testdata['policyInput'] = $testdata['policyInput'] + [
            'conditions' => [],
            'fields' => []
        ];

        $client = new StorageClient([
            'keyFilePath' => __DIR__ . '/data/signed-url-v4-service-account.json'
        ]);

        $generationTimestamp = \DateTimeImmutable::createFromFormat(
            \DateTime::RFC3339,
            $testdata['policyInput']['timestamp']
        );
        $bucket = $client->bucket($testdata['policyInput']['bucket']);

        $expiration = $generationTimestamp->format('U') + $testdata['policyInput']['expiration'];

        $hostnameOptions = $this->getHostnameOptions($testdata['policyInput']);

        $conditions = [];
        foreach ($testdata['policyInput']['conditions'] as $key => $condition) {
            if ($key === 'startsWith') {
                $key = 'starts-with';
            }

            if ($key === 'contentLengthRange') {
                $key = 'content-length-range';
            }

            if (!is_array($condition)) {
                $condition = [$condition];
            }

            $conditions[] = array_merge([$key], $condition);
        }

        $options = [
            'timestamp' => $generationTimestamp,
            'fields' => $testdata['policyInput']['fields'],
            'conditions' => $conditions,
        ];

        $policy = $bucket->generateSignedPostPolicyV4(
            $testdata['policyInput']['object'],
            $expiration,
            $hostnameOptions + $options
        );

        $decodedPolicy = base64_decode($policy['fields']['policy']);
        $this->assertEquals($testdata['policyOutput']['fields'], $policy['fields']);
        $this->assertEquals($testdata['policyOutput']['url'], $policy['url']);
    }

    public function signedUrlConformanceCases()
    {
        self::set_up_before_class();

        // rekey with description for more useful error reporting.
        $out = [];
        foreach (self::$cases['signingV4Tests'] as $case) {
            $desc = $case['description'];
            unset($case['description']);

            if (isset($case['urlStyle']) && $case['urlStyle'] === 'BUCKET_BOUND_HOSTNAME') {
                $cnameCase = $case;
                $cnameCase['cname'] = $case['bucketBoundHostname'];
                $out[$desc . ' CNAME backwards compatibility'] = [$cnameCase];
            }

            $out[$desc] = [$case];
        }

        return $out;
    }

    public function postPolicyConformanceCases()
    {
        self::set_up_before_class();

        // rekey with description for more useful error reporting.
        $out = [];
        foreach (self::$cases['postPolicyV4Tests'] as $case) {
            $desc = $case['description'];

            $out[$case['description']] = [$case];
            unset($case['description']);

            if (isset($case['urlStyle']) && $case['urlStyle'] === 'BUCKET_BOUND_HOSTNAME') {
                $cnameCase = $case;
                $cnameCase['cname'] = $case['bucketBoundHostname'];
                $out[$desc . ' CNAME backwards compatibility'] = [$cnameCase];
            }

            $out[$desc] = [$case];
        }

        return $out;
    }

    private function getHostnameOptions(array $testdata)
    {
        $options = [];
        $options['virtualHostedStyle'] = false;
        if (isset($testdata['urlStyle'])) {
            switch ($testdata['urlStyle']) {
                case 'VIRTUAL_HOSTED_STYLE':
                    $options['virtualHostedStyle'] = true;
                    break;

                case 'BUCKET_BOUND_HOSTNAME':
                    $options['bucketBoundHostname'] = $testdata['bucketBoundHostname'];
                    break;

                default:
                    throw new \Exception('url style ' . $testdata['urlStyle'] . ' not implemented.');
            }
        }

        if (isset($testdata['scheme'])) {
            $options['scheme'] = $testdata['scheme'];
        }

        return $options;
    }
}
