<?php
/**
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\PubSub\Tests\System;

use Google\Cloud\PubSub\Message;
use Google\Cloud\PubSub\Schema;
use Google\Cloud\PubSub\V1\Encoding;
use Google\Cloud\PubSub\V1\Schema\Type;
use Utilities\StateProto;

/**
 * @group pubsub
 * @group pubsub-schema
 */
class SchemaTest extends PubSubTestCase
{
    public function testSchemaManagementAvro()
    {
        $definition = file_get_contents(__DIR__ . '/testdata/schema.avsc');
        $schema = self::$grpcClient->createSchema(
            uniqid(self::TESTING_PREFIX),
            Type::AVRO,
            $definition
        );

        self::$deletionQueue->add($schema);

        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertTrue($schema->exists());
        $this->assertEquals($schema->name(), $schema->reload()['name']);
        $this->assertEquals(trim($definition), trim($schema->info()['definition']));

        if (self::$grpcClient instanceof PubSubClientGrpc) {
            $this->assertEquals(Type::AVRO, $schema->info()['type']);
        } else {
            $this->assertEquals('AVRO', $schema->info()['type']);
        }

        $schemas = self::$grpcClient->schemas();
        $hasSchema = false;
        foreach ($schemas as $s) {
            if ($schema->name() == $s->name()) {
                $hasSchema = true;
                break;
            }
        }

        $this->assertTrue($hasSchema);
    }

    public function testSchemaManagementProtobuf()
    {
        $definition = file_get_contents(__DIR__ . '/testdata/schema.proto');
        $schema = self::$grpcClient->createSchema(
            uniqid(self::TESTING_PREFIX),
            Type::PROTOCOL_BUFFER,
            $definition
        );

        self::$deletionQueue->add($schema);

        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertTrue($schema->exists());
        $this->assertEquals($schema->name(), $schema->reload()['name']);
        $this->assertEquals(trim($definition), trim($schema->info()['definition']));

        if (self::$grpcClient instanceof PubSubClientGrpc) {
            $this->assertEquals(Type::PROTOCOL_BUFFER, $schema->info()['type']);
        } else {
            $this->assertEquals('PROTOCOL_BUFFER', $schema->info()['type']);
        }

        $schemas = self::$grpcClient->schemas();
        $hasSchema = false;
        foreach ($schemas as $s) {
            if ($schema->name() == $s->name()) {
                $hasSchema = true;
                break;
            }
        }

        $this->assertTrue($hasSchema);
    }

    public function testPublishWithAvroSchemaBinary()
    {
        $definition = file_get_contents(__DIR__ . '/testdata/schema.avsc');
        $schema = self::$grpcClient->createSchema(
            uniqid(self::TESTING_PREFIX),
            Type::AVRO,
            $definition
        );

        self::$deletionQueue->add($schema);

        $topic = self::topic(self::$grpcClient, [
            'schemaSettings' => [
                'schema' => $schema,
                'encoding' => Encoding::BINARY,
            ]
        ]);

        $data = [
            'name' => 'Alaska',
            'post_abbr' => 'AK',
        ];

        // wow this is a pain.
        $io = new \AvroStringIO();
        $schema = \AvroSchema::parse($definition);
        $writer = new \AvroIODatumWriter($schema);
        $dataWriter = new \AvroDataIOWriter($io, $writer, $schema);
        $dataWriter->append($data);

        $dataWriter->close();

        $topic->publish(new Message([
            'data' => base64_encode($io->string()),
        ]));
    }

    public function testPublishWithAvroSchemaJson()
    {
        $definition = file_get_contents(__DIR__ . '/testdata/schema.avsc');
        $schema = self::$grpcClient->createSchema(
            uniqid(self::TESTING_PREFIX),
            Type::AVRO,
            $definition
        );

        self::$deletionQueue->add($schema);

        $topic = self::topic(self::$grpcClient, [
            'schemaSettings' => [
                'schema' => $schema,
                'encoding' => 'JSON',
            ]
        ]);

        $data = [
            'name' => 'Alaska',
            'post_abbr' => 'AK',
        ];

        $topic->publish(new Message([
            'data' => json_encode($data),
        ]));
    }

    public function testPublishWithProtobufSchemaBinary()
    {
        $definition = file_get_contents(__DIR__ . '/testdata/schema.proto');
        $schema = self::$grpcClient->createSchema(
            uniqid(self::TESTING_PREFIX),
            Type::PROTOCOL_BUFFER,
            $definition
        );

        self::$deletionQueue->add($schema);

        $topic = self::topic(self::$grpcClient, [
            'schemaSettings' => [
                'schema' => $schema,
                'encoding' => 'BINARY',
            ]
        ]);

        $data = new StateProto([
            'name' => 'Alaska',
            'post_abbr' => 'AK',
        ]);

        $topic->publish(new Message([
            'data' => $data->serializeToString(),
        ]));
    }

    public function testPublishWithProtobufSchemaJson()
    {
        $definition = file_get_contents(__DIR__ . '/testdata/schema.proto');
        $schema = self::$grpcClient->createSchema(
            uniqid(self::TESTING_PREFIX),
            Type::PROTOCOL_BUFFER,
            $definition
        );

        self::$deletionQueue->add($schema);

        $topic = self::topic(self::$grpcClient, [
            'schemaSettings' => [
                'schema' => $schema,
                'encoding' => 'JSON',
            ]
        ]);

        $data = [
            'name' => 'Alaska',
            'post_abbr' => 'AK',
        ];

        $topic->publish(new Message([
            'data' => json_encode($data),
        ]));
    }
}
