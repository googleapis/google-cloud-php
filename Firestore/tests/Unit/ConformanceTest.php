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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Core\Testing\ArrayHasSameValuesToken;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;
use Google\Cloud\Firestore\PathTrait;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use Google\Cloud\Firestore\V1\StructuredQuery\CompositeFilter\Operator as CompositFilterOperator;
use Google\Cloud\Firestore\V1\StructuredQuery\Direction;
use Google\Cloud\Firestore\V1\StructuredQuery\FieldFilter\Operator as FieldFilterOperator;
use Google\Cloud\Firestore\V1\StructuredQuery\UnaryFilter\Operator as UnaryFilterOperator;
use Google\Cloud\Firestore\ValueMapper;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;
use Prophecy\Exception\Call\UnexpectedCallException;

/**
 * @group firestore
 * @group firestore-conformance
 */
class ConformanceTest extends TestCase
{
    use GrpcTestTrait;
    use PathTrait;
    use TimeTrait;

    const SUITE_FILENAME = 'firestore-test-suite.binproto';

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
        'set-merge: Delete with merge',
        'set-merge: Merge fields must all be present in data',
        'set-merge: One merge path cannot be the prefix of another',
    ];

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->client = TestHelpers::stub(FirestoreClient::class, [
            [
                'projectId' => 'projectID'
            ]
        ]);

        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    /**
     * @dataProvider cases
     * @group firestore-conformance-get
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
     * @dataProvider cases
     * @group firestore-conformance-create
     */
    public function testCreate($test)
    {
        $this->setupCommitRequest($test, function ($test) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit(new ArrayHasSameValuesToken($this->injectPbValues($request)))
                ->shouldBeCalled()->willReturn([]);
        });

        $this->executeAndHandleError($test, function ($test) {
            $this->client->document($this->relativeName($test['docRefPath']))
                ->create($this->generateFields($test['jsonData']));
        });
    }

    /**
     * @dataProvider cases
     * @group firestore-conformance-set
     */
    public function testSet($test)
    {
        $this->setupCommitRequest($test, function ($test) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit(new ArrayHasSameValuesToken($this->injectPbValues($request)))
                ->shouldBeCalled()->willReturn([]);
        });

        $this->client->___setProperty('connection', $this->connection->reveal());

        $this->executeAndHandleError($test, function ($test) {
            $options = [];
            if (isset($test['option']['all']) && $test['option']['all']) {
                $options = ['merge' => true];
            }

            $this->client->document($this->relativeName($test['docRefPath']))
                ->set($this->generateFields($test['jsonData']), $options);
        });
    }

    /**
     * @dataProvider cases
     * @group firestore-conformance-updatepaths
     */
    public function testUpdatePaths($test)
    {
        $this->setupCommitRequest($test, function ($test) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit(new ArrayHasSameValuesToken($this->injectPbValues($request)))
                ->shouldBeCalled()->willReturn([]);
        });

        $this->executeAndHandleError($test, function ($test) {
            $fields = [];
            foreach ($test['fieldPaths'] as $key => $val) {
                $fields[] = [
                    'path' => new FieldPath($val['field']),
                    'value' => $this->injectSentinel(
                        $this->decodeJson($test['jsonValues'][$key], true)
                    )
                ];
            }

            $options = $this->formatOptions($test);

            $this->client->document($this->relativeName($test['docRefPath']))
                ->update($fields, $options);
        });
    }

    /**
     * @dataProvider cases
     * @group firestore-conformance-delete
     */
    public function testDelete($test)
    {
        $this->setupCommitRequest($test, function ($test) {
            $request = $test['request'];
            if (isset($request['transaction']) && !$request['transaction']) {
                unset($request['transaction']);
            }

            $this->connection->commit(new ArrayHasSameValuesToken($this->injectPbValues($request)))
                ->shouldBeCalled()->willReturn([]);
        });

        $options = $this->formatOptions($test);

        $this->executeAndHandleError($test, function ($test) use ($options) {
            $this->client->document($this->relativeName($test['docRefPath']))
                ->delete($options);
        });
    }

    /**
     * @dataProvider cases
     * @group firestore-conformance-query
     */
    public function testQuery($test)
    {
        $query = isset($test['query'])
            ? $this->injectPbValues($test['query'])
            : [];
        if (isset($query['from'][0]['allDescendants']) && !$query['from'][0]['allDescendants']) {
            unset($query['from'][0]['allDescendants']);
        }

        $times = (isset($test['isError']) && $test['isError']) ? 0 : 1;
        $this->connection->runQuery(new ArrayHasSameValuesToken([
            'parent' => $this->parentPath($test['collPath']),
            'structuredQuery' => $query,
            'retries' => 0
        ]))->shouldBeCalledTimes($times)->willReturn(new \ArrayIterator([]));

        $this->client->___setProperty('connection', $this->connection->reveal());

        $query = $this->client->collection($this->relativeName($test['collPath']));

        $this->executeAndHandleError($test, function ($test) use ($query) {
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
                        $path = count($clause['where']['path']['field']) === 1
                            ? $clause['where']['path']['field'][0]
                            : new FieldPath($clause['where']['path']['field']);

                        $query = $query->where(
                            $path,
                            $clause['where']['op'],
                            $this->injectWhere(
                                $this->injectSentinel(
                                    $this->decodeJson($clause['where']['jsonValue'])
                                )
                            )
                        );
                        break;

                    case 'offset':
                        $query = $query->offset($clause['offset']);
                        break;

                    case 'limit':
                        $query = $query->limit($clause['limit']);
                        break;

                    case 'orderBy':
                        $path = count($clause['orderBy']['path']['field']) === 1
                            ? $clause['orderBy']['path']['field'][0]
                            : new FieldPath($clause['orderBy']['path']['field']);

                        $query = $query->orderBy(
                            $path,
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
                                $values[] = $this->injectSentinel($this->decodeJson($value, true));
                            }
                        }

                        if ($values === []) {
                            $values = null;
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
                                $this->decodeJson($clause[$name]['docSnapshot']['jsonData']),
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
        });
    }

    private function setupCommitRequest(array $test, callable $call)
    {
        $test += [
            'isError' => false
        ];

        if (!$test['isError']) {
            $call($test);
        } else {
            $this->connection->commit(Argument::any())
                ->shouldNotBeCalled()->willReturn([]);
        }

        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    private function executeAndHandleError(array $test, callable $executeTest)
    {
        $hasError = false;
        try {
            $executeTest($test);
        } catch (\Exception $e) {
            if ($e instanceof UnexpectedCallException) {
                throw $e;
            }

            $hasError = $e;
        }

        if (isset($test['isError']) && $test['isError']) {
            $this->assertTrue((bool) $hasError);
        } elseif ($hasError) {
            throw $hasError;
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
                $updateTime = $this->parseTimeString($test['precondition']['updateTime']);
                $test['precondition']['updateTime'] = [
                    'seconds' => $updateTime[0]->format('U'),
                    'nanos' => $updateTime[1]
                ];

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
        $fields = $this->decodeJson($data, false);
        return $this->injectSentinels($fields);
    }

    private function injectSentinels($fields)
    {
        if (!is_array($fields)) {
            return $fields;
        }

        foreach ($fields as $name => &$value) {
            $value = $this->injectSentinel($value);
        }

        return $fields;
    }

    private function injectSentinel($value)
    {
        if (is_array($value) && !empty($value)) {
            if (in_array(array_values($value)[0], ['ArrayUnion', 'ArrayRemove'], true)) {
                $type = lcfirst(array_shift($value));
                return FieldValue::$type($this->injectSentinels($value));
            }

            return $this->injectSentinels($value);
        }

        if ($value === 'Delete') {
            return FieldValue::deleteField();
        }

        if ($value === 'ServerTimestamp') {
            return FieldValue::serverTimestamp();
        }

        if ($value === 'EMPTY_MAP') {
            return (object) [];
        }

        return $value;
    }

    private function injectPbValues(array $request, $parent = null)
    {
        foreach ($request as $key => &$clause) {
            if (is_array($clause)) {
                $clause = $this->injectPbValues($clause, $key);
                continue;
            }

            if ($key === 'op') {
                if ($parent === 'fieldFilter') {
                    $clause = FieldFilterOperator::value($clause);
                } elseif ($parent === 'unaryFilter') {
                    $clause = UnaryFilterOperator::value($clause);
                } elseif ($parent === 'compositeFilter') {
                    if ($clause === 'AND') {
                        $clause = 'PBAND';
                    }
                    $clause = CompositFilterOperator::value($clause);
                }
            }

            if ($key === 'direction') {
                $clause = Direction::value($clause);
            }

            if ($key === 'setToServerValue') {
                $clause = ServerValue::value($clause);
            }

            if ($key === 'updateTime') {
                $updateTime = $this->parseTimeString($clause);
                $clause = [
                    'seconds' => $updateTime[0]->format('U'),
                    'nanos' => $updateTime[1]
                ];
            }
        }

        return $request;
    }

    private function injectWhere($value)
    {
        if ($value === 'NaN') {
            return NAN;
        }

        return $value;
    }

    private function decodeJson($json, $returnEmptyMapAsObject = false)
    {
        if ($json === '{}') {
            return $returnEmptyMapAsObject
                ? (object) []
                : [];
        }
        $json = str_replace('{}', '"EMPTY_MAP"', $json);

        return json_decode($json, true);
    }

    private function setupCases(array $types, array $excludes)
    {
        if (self::$cases) {
            return self::$cases;
        }

        $files = glob(__DIR__ . '/conformance/v1/*.json');

        $cases = [];
        foreach ($files as $fileName) {
            $file = json_decode(file_get_contents($fileName), true);

            foreach ($file['tests'] as $test) {
                $matches = array_values(array_intersect($types, array_keys($test)));
                if (!$matches) {
                    if (in_array($test['description'], $excludes)) {
                        self::$skipped[] = [$test['description']];
                        continue;
                    }

                    continue;
                }

                $type = $matches[0];

                if (in_array($test['description'], $excludes)) {
                    self::$skipped[] = [$test['description']];
                    continue;
                }

                $cases[] = [
                    'description' => $test['description'],
                    'type' => $type,
                    'test' => $test[$type]
                ];
            }
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

        $cases = array_filter(
            $this->setupCases($this->testTypes, $this->excludes),
            function ($case) use ($type) {
                return $case['type'] === $type;
            }
        );

        $res = [];
        foreach ($cases as $case) {
            $res[$case['description']] = [$case['test'], $case['description']];
        }

        return $res;
    }
}
