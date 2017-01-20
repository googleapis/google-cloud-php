<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\System\Logging;

/**
 * @group logging
 */
class ManageSinksTest extends LoggingTestCase
{
    /**
     * @dataProvider clientProvider
     */
    public function testListsSinks($client)
    {
        $found = true;
        $name = uniqid(self::TESTING_PREFIX);
        $sink = $client->createSink(
            $name,
            sprintf(
                'bigquery.googleapis.com/projects/%s/datasets/%s',
                self::$dataset->identity()['projectId'],
                self::$dataset->identity()['datasetId']
            ),
            [
                'outputVersionFormat' => 'V2',
                'filter' => 'severity >= ERROR'
            ]
        );
        self::$deletionQueue[] = $sink;

        $sinks = iterator_to_array($client->sinks());

        foreach ($sinks as $sink) {
            if ($sink->name() === $name) {
                $found = true;
            }
        }

        $this->assertTrue($found);
    }

    /**
     * @dataProvider createSinkProvider
     */
    public function testCreateSink($client, $destination)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $options = [
            'outputVersionFormat' => 'V2',
            'filter' => 'severity >= ERROR'
        ];
        $this->assertFalse($client->sink($name)->exists());

        $sink = $client->createSink($name, $destination, $options);
        self::$deletionQueue[] = $sink;

        $this->assertTrue($client->sink($name)->exists());
        $this->assertEquals($destination, $sink->info()['destination']);
        $this->assertEquals($options['outputVersionFormat'], $sink->info()['outputVersionFormat']);
        $this->assertEquals($options['filter'], $sink->info()['filter']);
    }

    public function createSinkProvider()
    {
        self::setUpBeforeClass();
        $bucket = self::$bucket;
        $bucket->acl()->add('group-cloud-logs@google.com', 'OWNER');-
        $bucketDest = sprintf('storage.googleapis.com/%s', $bucket->name());
        $datasetDest = sprintf(
            'bigquery.googleapis.com/projects/%s/datasets/%s',
            self::$dataset->identity()['projectId'],
            self::$dataset->identity()['datasetId']
        );
        $topicDest = sprintf('pubsub.googleapis.com/%s', self::$topic->info()['name']);

        return [
            [self::$restClient, $bucketDest],
            [self::$restClient, $datasetDest],
            [self::$restClient, $topicDest],
            [self::$grpcClient, $bucketDest],
            [self::$grpcClient, $datasetDest],
            [self::$grpcClient, $topicDest]
        ];
    }

    /**
     * @dataProvider clientProvider
     */
    public function testUpdateSink($client)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $destination = sprintf('pubsub.googleapis.com/%s', self::$topic->info()['name']);
        $createOptions = [
            'outputVersionFormat' => 'V2',
            'filter' => 'severity >= ERROR'
        ];
        $updateOptions = [
            'filter' => 'severity >= DEBUG'
        ];
        $sink = $client->createSink($name, $destination, $createOptions);
        self::$deletionQueue[] = $sink;

        $info = $sink->update($updateOptions);

        $this->assertEquals($name, $sink->name());
        $this->assertEquals($updateOptions['filter'], $info['filter']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testReloadSink($client)
    {
        $name = uniqid(self::TESTING_PREFIX);
        $options = [
            'outputVersionFormat' => 'V2',
            'filter' => 'severity >= ERROR'
        ];
        $destination = sprintf('pubsub.googleapis.com/%s', self::$topic->info()['name']);
        $sink = $client->createSink($name, $destination, $options);

        $this->assertEquals($options['outputVersionFormat'], $sink->reload()['outputVersionFormat']);
    }
}
