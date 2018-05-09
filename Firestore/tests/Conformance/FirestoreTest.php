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
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\PathTrait;
use Google\Cloud\Firestore\ValueMapper;
use Google\Cloud\Tests\Conformance\Firestore\FirestoreTestSuite as Message;
use Google\Protobuf\Internal\CodedInputStream;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Exception\Call\UnexpectedCallException;

/**
 * @group firestore
 */
class FirestoreTest extends TestCase
{
    use PathTrait;

    private static $cases = [];
    private static $skipped = [];

    private $testTypes = ['get', 'create', 'set', 'update', 'updatePaths', 'delete', 'query'];
    private $client;
    private $connection;

    private $excludes = [
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
        "set-merge: Delete with merge",
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
     * @dataProvider getCases
     * @group firestore-get
     */
    public function testGet($test)
    {
        $this->connection->batchGetDocuments(Argument::withEntry('documents', [$test['request']['name']]))
            ->shouldBeCalled()
            ->willReturn(new \ArrayIterator([[]]));
        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->client->document($this->relativeName($test['docRefPath']))->snapshot();
    }

    /**
     * @dataProvider createCases
     * @group firestore-create
     */
    public function testCreate($test)
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

    /**
     * @dataProvider setCases
     * @group firestore-set
     */
    public function testSet($test)
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

    /**
     * @dataProvider updateCases
     * @group firestore-update
     */
    public function testUpdate($test)
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

    /**
     * @dataProvider updatePathsCases
     * @group firestore-updatepaths
     */
    public function testUpdatePaths($test)
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

    /**
     * @dataProvider deleteCases
     * @group firestore-delete
     */
    public function testDelete($test)
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

    /**
     * @dataProvider queryCases
     * @group firestore-query
     */
    public function testQuery($test, $desc)
    {
        $times = (isset($test['isError']) && $test['isError']) ? 0 : 1;
        $this->connection->runQuery(new ArrayHasSameValuesToken([
            'parent' => $this->parentPath($test['collPath']),
            'structuredQuery' => isset($test['query']) ? $test['query'] : [],
            'retries' => 0
        ]))->shouldBeCalledTimes($times)->willReturn(new \ArrayIterator([]));

        $this->client->___setProperty('connection', $this->connection->reveal());

        $query = $this->client->collection($this->relativeName($test['collPath']));

        $hasError = false;
        try {
            foreach ($test['clauses'] as $clause) {
                $name = array_keys($clause)[0];
                switch ($name) {
                    case 'select':
                        $fields = [];
                        foreach ($clause['select']['fields'] as $field) {
                            $fields[] = $field['field'][0];
                        }

                        $query = $query->select($fields);
                        break;

                    case 'where':
                        $query = $query->where(
                            $clause['where']['path']['field'][0],
                            $clause['where']['op'],
                            $this->injectSentinel(json_decode($clause['where']['jsonValue'], true))
                        );
                        break;

                    case 'offset':
                        $query = $query->offset($clause['offset']);
                        break;

                    case 'limit':
                        $query = $query->limit($clause['limit']);
                        break;

                    case 'orderBy':
                        $query = $query->orderBy(
                            $clause['orderBy']['path']['field'][0],
                            $clause['orderBy']['direction']
                        );
                        break;

                    case 'startAt':
                    case 'startAfter':
                    case 'endBefore':
                    case 'endAt':
                        $values = [];
                        if (isset($clause[$name]['jsonValues'])) {
                            foreach ($clause[$name]['jsonValues'] as $value) {
                                $values[] = $this->injectSentinel(json_decode($value, true));
                            }
                        }

                        if (isset($clause[$name]['docSnapshot'])) {
                            $coll = $this->prophesize(CollectionReference::class);
                            $coll->name()->willReturn($this->parentPath($clause[$name]['docSnapshot']['path']));
                            $ref = $this->prophesize(DocumentReference::class);
                            $ref->parent()->willReturn($coll->reveal());
                            $ref->name()->willReturn($clause[$name]['docSnapshot']['path']);

                            $mapper = new ValueMapper(
                                $this->prophesize(ConnectionInterface::class)->reveal(),
                                false
                            );

                            $values = new DocumentSnapshot(
                                $ref->reveal(),
                                $mapper,
                                [],
                                json_decode($clause[$name]['docSnapshot']['jsonData'], true),
                                true
                            );
                        }

                        $query = $query->$name($values);
                        break;

                    default:
                        throw new \RuntimeException('clause '. $name .' is not handled');
                }
            }

            $query->documents(['maxRetries' => 0]);
        } catch (UnexpectedCallException $e) {
            throw $e;
        } catch (\Exception $e) {
            $hasError = true;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue($hasError);
        }
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

    public function cases($type)
    {
        $cases = array_filter($this->setupCases(), function ($case) use ($type) {
            return $case['type'] === $type;
        });

        $res = [];
        foreach ($cases as $case) {
            $res[$case['description']] = [$case['test'], $case['description']];
        }

        return $res;
    }

    private function setupCases()
    {
        if (self::$cases) {
            return self::$cases;
        }

        $serializer = new Serializer;

        $str = file_get_contents(__DIR__ . '/proto/firestore-test-suite.binproto');
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

            if (in_array($case['description'], $this->excludes)) {
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

    public function getCases() { return $this->cases('get'); }
    public function createCases() { return $this->cases('create'); }
    public function setCases() { return $this->cases('set'); }
    public function updateCases() { return $this->cases('update'); }
    public function updatePathsCases() { return $this->cases('updatePaths'); }
    public function deleteCases() { return $this->cases('delete'); }
    public function queryCases() { return $this->cases('query'); }
    public function skippedCases() { return self::$skipped; }
}
