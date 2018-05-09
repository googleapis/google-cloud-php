<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore\Tests\Conformance;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Testing\ArrayHasSameValuesToken;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\PathTrait;
use Google\Cloud\Tests\Conformance\Firestore\FirestoreTestSuite as Message;
use Google\Protobuf\Internal\CodedInputStream;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Exception\Call\UnexpectedCallException;

/**
 * @group firestore
 */
class FirestoreTest extends TestCase
{
    use PathTrait;

    const TEST_FILE = 'https://github.com/GoogleCloudPlatform/google-cloud-common/raw/master/testing/firestore/testdata/test-suite.binproto';

    private $testTypes = ['get', 'create', 'set', 'update', 'updatePaths', 'delete', 'query'];
    private $client;
    private $connection;

    private $skipped = [
        // need mergeFields support
        'set-merge: Merge with a field',
        'set-merge: Merge with a nested field',
        'set-merge: Merge field is not a leaf',
        'set-merge: Merge with FieldPaths',
        'set-merge: ServerTimestamp with Merge of both fields',
        'set-merge: If is ServerTimestamp not in Merge, no transform',
        'set-merge: If no ordinary values in Merge, no write',
        'set-merge: non-leaf merge field with ServerTimestamp',
        'set-merge: non-leaf merge field with ServerTimestamp alone',

        // need to strip empty maps
        'create: nested ServerTimestamp field',
        'create: multiple ServerTimestamp fields',
        'set: nested ServerTimestamp field',
        'update: ServerTimestamp with dotted field',
        'update: nested ServerTimestamp field',
        'update: multiple ServerTimestamp fields',
        'update-paths: nested ServerTimestamp field',
        'update-paths: multiple ServerTimestamp fields',
    ];

    public function setUp()
    {
        $this->client = TestHelpers::stub(FirestoreClient::class, [
            [
                'projectId' => 'projectID'
            ]
        ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    /**
     * @dataProvider cases
     */
    public function testConformance($description, $type, array $test)
    {
        if (in_array($description, $this->skipped)) {
            $this->markTestSkipped('manually skipped '. $description);
            return;
        }

        switch ($type) {
            case 'get':
                $method = 'runGet';
                break;

            case 'create':
                $method = 'runCreate';
                break;

            case 'set':
                $method = 'runSet';
                break;

            case 'update':
                $method = 'runUpdate';
                break;

            case 'updatePaths':
                $method = 'runUpdatePaths';
                break;

            case 'delete':
                $method = 'runDelete';
                break;

            default :
                $this->markTestSkipped(sprintf(
                    'Skipped because test type `%s` does not have a handler.',
                    $type
                ));
        }

        return $this->$method($test);
    }

    private function runGet($test)
    {
        $this->connection->batchGetDocuments(Argument::withEntry('documents', [$test['request']['name']]))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([[]]));
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->client->document($this->relativeName($test['docRefPath']))->snapshot();
    }

    private function runCreate($test)
    {
        if (isset($test['request'])) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit($request)
                ->shouldBeCalled()->willReturn([]);
            $this->client->___setProperty('connection', $this->connection->reveal());
        }

        $hasError = false;
        try {
            $this->client->document($this->relativeName($test['docRefPath']))
                ->create($this->generateFields($test['jsonData']));
        } catch (\Exception $e) {
            if ($e instanceof UnexpectedCallException) {
                throw $e;
            }

            $hasError = true;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue($hasError);
        }
    }

    private function runSet($test)
    {
        if (isset($test['request'])) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit(new ArrayHasSameValuesToken($request))
                ->shouldBeCalled()->willReturn([]);
            $this->client->___setProperty('connection', $this->connection->reveal());
        }

        $hasError = false;
        try {
            $options = [];
            if (isset($test['option']['all']) && $test['option']['all']) {
                $options = ['merge' => true];
            }

            $this->client->document($this->relativeName($test['docRefPath']))
                ->set($this->generateFields($test['jsonData']), $options);
        } catch (\Exception $e) {
            if ($e instanceof UnexpectedCallException) {
                throw $e;
            }

            $hasError = true;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue($hasError);
        }
    }

    private function runUpdate($test)
    {
        if (isset($test['request'])) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit(new ArrayHasSameValuesToken($request))
                ->shouldBeCalled()->willReturn([]);
            $this->client->___setProperty('connection', $this->connection->reveal());
        }

        $fields = [];
        foreach ($this->generateFields($test['jsonData']) as $key => $val) {
            $fields[] = ['path' => $key, 'value' => $val];
        }

        $options = $this->formatOptions($test);

        $hasError = false;
        try {
            $this->client->document($this->relativeName($test['docRefPath']))
                ->update($fields, $options);
        } catch (\Exception $e) {
            if ($e instanceof UnexpectedCallException) {
                throw $e;
            }

            $hasError = true;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue($hasError);
        } elseif (isset($e)) {
            throw $e;
        }
    }

    private function runUpdatePaths($test)
    {
        if (isset($test['request'])) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            if (!isset($test['isError']) || !$test['isError']) {
                $this->connection->commit(new ArrayHasSameValuesToken($request))
                    ->shouldBeCalled()->willReturn([]);
            }

            $this->client->___setProperty('connection', $this->connection->reveal());
        }

        $data = [];
        foreach ($test['fieldPaths'] as $key => $val) {
            $data[] = [
                'path' => new FieldPath($val['field']),
                'value' => $this->injectSentinel(json_decode($test['jsonValues'][$key], true))
            ];
        }

        $options = $this->formatOptions($test);

        $hasError = false;
        try {
            $this->client->document($this->relativeName($test['docRefPath']))
                ->update($data, $options);
        } catch (\Exception $e) {
            if ($e instanceof UnexpectedCallException) {
                throw $e;
            }

            $hasError = true;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue($hasError);
        }
    }

    private function runDelete($test)
    {
        if (isset($test['request'])) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit($request)
                ->shouldBeCalled()->willReturn([]);
            $this->client->___setProperty('connection', $this->connection->reveal());
        }

        $options = $this->formatOptions($test);

        $hasError = false;
        try {
            $this->client->document($this->relativeName($test['docRefPath']))
                ->delete($options);
        } catch (\Exception $e) {
            if ($e instanceof UnexpectedCallException) {
                throw $e;
            }

            $hasError = true;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue($hasError);
        }
    }

    private function formatOptions(array $test)
    {
        $options = [];
        if (isset($test['precondition'])) {
            if (isset($test['precondition']['exists'])) {
                $options['precondition'] = ['exists' => $test['precondition']['exists']];
            }

            if (isset($test['precondition']['updateTime'])) {
                $test['precondition']['updateTime'] += ['seconds' => 0, 'nanos' => 0];

                $options['precondition'] = [
                    'updateTime' => new Timestamp(
                        \DateTime::createFromFormat('U', (string) $test['precondition']['updateTime']['seconds']),
                        $test['precondition']['updateTime']['nanos']
                    )
                ];
            }
        }

        return $options;
    }

    private function generateFields($data)
    {
        $fields = json_decode($data, true);
        return $this->injectSentinels($fields);

    }

    private function injectSentinels(array $fields)
    {
        foreach ($fields as $name => &$value) {
            $value = $this->injectSentinel($value);
        }

        return $fields;
    }

    private function injectSentinel($value)
    {
        if (is_array($value)) {
            $value = $this->injectSentinels($value);
        }

        if ($value === 'Delete') {
            $value = FieldValue::deleteField();
        }

        if ($value === 'ServerTimestamp') {
            $value = FieldValue::serverTimestamp();
        }

        return $value;
    }

    public function cases()
    {
        $serializer = new Serializer;

        $bytes = (new Client)->get(self::TEST_FILE)->getBody();
        $str = (string)$bytes;
        $suite = new Message;
        $suite->mergeFromString($str);

        $cases = [];
        foreach ($suite->getTests() as $test) {
            $case = $serializer->encodeMessage($test);
            $matches = array_values(array_intersect($this->testTypes, array_keys($case)));
            if (!$matches) {
                $keys = array_keys($case);
                throw new \Exception(sprintf(
                    'Unknown test type! Keys were `%s`',
                    implode(', ', $keys)
                ));
            }

            $type = $matches[0];

            $cases[] = [
                $case['description'],
                $type,
                $case[$type]
            ];
        }

        return $cases;
    }
}
