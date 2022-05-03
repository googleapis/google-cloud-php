<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Datastore\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\EmulatorTrait;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Datastore\DatastoreClient as ManualDatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\CompositeFilter\Operator as CompositeFilterOperator;
use Google\Cloud\Datastore\V1\DatastoreClient;
use Google\Cloud\Datastore\V1\GqlQuery;
use Google\Cloud\Datastore\V1\Key;
use Google\Cloud\Datastore\V1\Key\PathElement;
use Google\Cloud\Datastore\V1\Mutation;
use Google\Cloud\Datastore\V1\PartitionId;
use Google\Cloud\Datastore\V1\PropertyFilter\Operator as PropertyFilterOperator;
use Google\Cloud\Datastore\V1\PropertyOrder\Direction;
use Google\Cloud\Datastore\V1\Query;
use Google\Cloud\Datastore\V1\ReadOptions;
use Google\Cloud\Datastore\V1\ReadOptions\ReadConsistency;
use Google\Cloud\Datastore\V1\TransactionOptions;
use Google\Protobuf\NullValue;

/**
 * Implementation of
 * [google.datastore.v1](https://cloud.google.com/datastore/docs/reference/data/rpc/google.datastore.v1).
 *
 * @internal
 */
class Grpc implements ConnectionInterface
{
    use EmulatorTrait;
    use GrpcTrait;

    /**
     * @var DatastoreClient
     */
    private $datastoreClient;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param array $config [optional]
     */
    public function __construct(array $config = [])
    {
        $config += [
            'emulatorHost' => null
        ];

        //@codeCoverageIgnoreStart
        $this->serializer = new Serializer([], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [], [
            'google.protobuf.Timestamp' => function ($v) {
                if (is_string($v)) {
                    $dt = new \DateTime($v);
                    return ['seconds' => $dt->format('U')];
                }
                return $v;
            }
        ]);
        //@codeCoverageIgnoreEnd

        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $grpcConfig = $this->getGaxConfig(
            ManualDatastoreClient::VERSION,
            isset($config['authHttpHandler'])
                ? $config['authHttpHandler']
                : null
        );

        if (isset($config['apiEndpoint'])) {
            $grpcConfig['apiEndpoint'] = $config['apiEndpoint'];
        }

        if ((bool) $config['emulatorHost']) {
            $grpcConfig += $this->emulatorGapicConfig($config['emulatorHost']);
        }

        $this->datastoreClient = isset($config['gapicDatastoreClient'])
            ? $config['gapicDatastoreClient']
            : $this->constructGapic(DatastoreClient::class, $grpcConfig);
    }

    /**
     * @param array $args
     */
    public function allocateIds(array $args)
    {
        $keys = $this->pluck('keys', $args);

        return $this->send([$this->datastoreClient, 'allocateIds'], [
            $this->pluck('projectId', $args),
            $this->keysList($keys),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function beginTransaction(array $args)
    {
        if (isset($args['transactionOptions'])) {
            $args['transactionOptions'] = $this->serializer->decodeMessage(
                new TransactionOptions,
                $args['transactionOptions']
            );
        }

        return $this->send([$this->datastoreClient, 'beginTransaction'], [
            $this->pluck('projectId', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function commit(array $args)
    {
        $mode = $this->pluck('mode', $args) === 'TRANSACTIONAL'
            ? Mode::TRANSACTIONAL
            : Mode::NON_TRANSACTIONAL;

        $mutations = $this->pluck('mutations', $args);
        foreach ($mutations as &$mutation) {
            $mutationType = array_keys($mutation)[0];
            $data = $mutation[$mutationType];
            if (isset($data['properties'])) {
                foreach ($data['properties'] as &$property) {
                    list ($type, $val) = $this->toGrpcValue($property);

                    $property[$type] = $val;
                }
            }

            $mutation[$mutationType] = $data;

            $mutation = $this->serializer->decodeMessage(new Mutation, $mutation);
        }

        return $this->send([$this->datastoreClient, 'commit'], [
            $this->pluck('projectId', $args),
            $mode,
            $mutations,
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function lookup(array $args)
    {
        $keys = $this->pluck('keys', $args);

        if (isset($args['readOptions'])) {
            $args['readOptions'] = $this->readOptions($args['readOptions']);
        }

        return $this->send([$this->datastoreClient, 'lookup'], [
            $this->pluck('projectId', $args),
            $this->keysList($keys),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function rollback(array $args)
    {
        return $this->send([$this->datastoreClient, 'rollback'], [
            $this->pluck('projectId', $args),
            $this->pluck('transaction', $args),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function runQuery(array $args)
    {
        $partitionId = $this->serializer->decodeMessage(
            new PartitionId,
            $this->pluck('partitionId', $args)
        );

        if (isset($args['readOptions'])) {
            $args['readOptions'] = $this->readOptions($args['readOptions']);
        }

        if (isset($args['query'])) {
            $query = $args['query'];
            if (isset($query['order'])) {
                foreach ($query['order'] as &$order) {
                    $order['direction'] = $order['direction'] === 'ASCENDING'
                        ? Direction::ASCENDING
                        : Direction::DESCENDING;
                }
            }

            if (isset($query['filter'])) {
                $query['filter'] = $this->convertFilterProps($query['filter']);
            }

            if (isset($query['limit'])) {
                $query['limit'] = [
                    'value' => $query['limit']
                ];
            }

            $args['query'] = $this->serializer->decodeMessage(
                new Query,
                $query
            );
        }

        if (isset($args['gqlQuery'])) {
            $gqlQuery = $args['gqlQuery'];

            if (isset($gqlQuery['namedBindings'])) {
                foreach ($gqlQuery['namedBindings'] as $name => &$binding) {
                    if (!isset($binding['value'])) {
                        continue;
                    }

                    $binding = $this->prepareQueryBinding($binding);
                }
            }

            if (isset($gqlQuery['positionalBindings'])) {
                foreach ($gqlQuery['positionalBindings'] as &$binding) {
                    if (!isset($binding['value'])) {
                        continue;
                    }

                    $binding = $this->prepareQueryBinding($binding);
                }
            }

            $args['gqlQuery'] = $this->serializer->decodeMessage(
                new GqlQuery,
                $gqlQuery
            );
        }

        return $this->send([$this->datastoreClient, 'runQuery'], [
            $this->pluck('projectId', $args),
            $partitionId,
            $args
        ]);
    }

    /**
     * Convert a list of keys to a list of {@see Google\Cloud\Datastore\V1\Key}.
     *
     * @param array[] $keys
     * @return Key[]
     */
    private function keysList(array $keys)
    {
        $out = [];
        foreach ($keys as $key) {
            $local = [];

            if (isset($key['partitionId'])) {
                $p = $this->arrayFilterRemoveNull([
                    'project_id' => isset($key['partitionId']['projectId'])
                        ? $key['partitionId']['projectId']
                        : null,
                    'namespace_id' => isset($key['partitionId']['namespaceId'])
                        ? $key['partitionId']['namespaceId']
                        : null
                ]);

                $local['partition_id'] = new PartitionId($p);
            }

            $local['path'] = [];
            if (isset($key['path'])) {
                foreach ($key['path'] as $element) {
                    $local['path'][] = new PathElement($element);
                }
            }

            $out[] = new Key($local);
        }

        return $out;
    }

    /**
     * Convert a query binding to an API-compatible value.
     *
     * @param array $binding The input binding data
     * @return array
     */
    private function prepareQueryBinding(array $binding)
    {
        $value = $binding['value'];

        list ($type, $val) = $this->toGrpcValue($value);

        $binding['value'][$type] = $val;

        return $binding;
    }

    /**
     * Convert read options into an API-compatible value.
     *
     * @param array $readOptions The input readOptions data.
     * @return array
     */
    private function readOptions(array $readOptions)
    {
        if (isset($readOptions['readConsistency'])) {
            switch ($readOptions['readConsistency']) {
                case 'STRONG':
                    $readOptions['readConsistency'] = ReadConsistency::STRONG;
                    break;

                case 'EVENTUAL':
                    $readOptions['readConsistency'] = ReadConsistency::EVENTUAL;
                    break;

                default:
                    //@codeCoverageIgnoreStart
                    throw new \InvalidArgumentException('Invalid value for Read Consistency.');
                    break;
                    //@codeCoverageIgnoreEnd
            }
        }

        return $this->serializer->decodeMessage(
            new ReadOptions,
            $readOptions
        );
    }

    /**
     * Convert Query filters to an API-compatible value.
     *
     * @param array $filter The input filter data
     * @return array
     */
    private function convertFilterProps(array $filter)
    {
        if (isset($filter['propertyFilter'])) {
            $operator = $filter['propertyFilter']['op'];

            try {
                if (is_int($operator)) {
                    // verify that the operator, given as enum value, exists.
                    PropertyFilterOperator::name($operator);
                } else {
                    // convert the operator, given as a string, to a grpc value.
                    $operator = PropertyFilterOperator::value($operator);
                }
            } catch (\UnexpectedValueException $e) {
                throw new \InvalidArgumentException($e->getMessage());
            }

            $filter['propertyFilter']['op'] = $operator;
        }

        if (isset($filter['compositeFilter'])) {
            $filter['compositeFilter']['op'] = CompositeFilterOperator::PBAND;

            foreach ($filter['compositeFilter']['filters'] as &$nested) {
                $nested = $this->convertFilterProps($nested);
            }
        }

        return $filter;
    }

    /**
     * Convert a property value to a gRPC value.
     *
     * @param array $property The input property.
     * @return array
     */
    private function toGrpcValue(array $property)
    {
        $type = array_keys($property)[0];
        $val = $property[$type];
        if ($val === null) {
            $val = NullValue::NULL_VALUE;
        }

        if ($type === 'timestampValue') {
            $val = $this->formatTimestampForApi($val);
        }

        if ($type === 'geoPointValue') {
            $val = $this->arrayFilterRemoveNull($val);
        }

        return [$type, $val];
    }
}
