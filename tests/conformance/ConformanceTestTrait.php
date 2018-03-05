<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\Cloud\Tests\Conformance;

use Google\ApiCore\Serializer;
use Google\Cloud\Tests\Conformance\Firestore\FirestoreTestSuite;

/**
 * Shared functionality for Conformance tests
 */
trait ConformanceTestTrait
{
    private static $cases = [];
    private static $skipped = [];

    private function setupCases($suite, array $types, array $excludes)
    {
        if (self::$cases) {
            return self::$cases;
        }

        $serializer = new Serializer;

        $str = file_get_contents($suite);
        $suite = new FirestoreTestSuite;
        $suite->mergeFromString($str);

        $cases = [];
        foreach ($suite->getTests() as $test) {
            $case = $serializer->encodeMessage($test);
            $matches = array_values(array_intersect($types, array_keys($case)));
            if (!$matches) {
                $keys = array_keys($case);
                throw new \Exception(sprintf(
                    'Unknown test type! Keys were `%s`',
                    implode(', ', $keys)
                ));
            }

            $type = $matches[0];

            if (in_array($case['description'], $excludes)) {
                self::$skipped[] = [$case['description']];
                continue;
            }

            $cases[] = [
                'description' => $case['description'],
                'type' => $type,
                'test' => $case[$type]
            ];
        }

        self::$cases = $cases;
        return $cases;
    }

    /**
     * Report skipped cases for measurement purposes.
     *
     * @dataProvider skippedCases
     */
    public function testSkipped($desc)
    {
        $this->markTestSkipped($desc);
    }

    public function skippedCases()
    {
        return self::$skipped;
    }

    public function cases($type)
    {
        if (strpos($type, 'test') === 0) {
            $type = lcfirst(str_replace('test', '', $type));
        }

        $suite = __DIR__ . '/proto/'. self::SUITE_FILENAME;
        $cases = array_filter($this->setupCases($suite, $this->testTypes, $this->excludes), function ($case) use ($type) {
            return $case['type'] === $type;
        });

        $res = [];
        foreach ($cases as $case) {
            $res[$case['description']] = [$case['test'], $case['description']];
        }

        return $res;
    }
}
