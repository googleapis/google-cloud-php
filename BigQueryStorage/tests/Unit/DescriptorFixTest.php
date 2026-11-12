<?php
/*
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\BigQuery\Storage\Tests\Unit;

use Google\Cloud\BigQuery\Storage\V1\ProtoSchema;
use Google\Protobuf\DescriptorProto;
use Google\Protobuf\Internal\Message;
use GPBMetadata\Google\Protobuf\DescriptorFix;
use LogicException;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquerystorage
 */
class DescriptorFixTest extends TestCase
{
    public function testDescriptorFixAutoloadBehavior(): void
    {
        $schema = new ProtoSchema();
        $this->assertInstanceOf(ProtoSchema::class, $schema);

        if (is_subclass_of(DescriptorProto::class, Message::class)) {
            $this->assertFalse(DescriptorFix::$is_initialized);
            $schema->setProtoDescriptor(new DescriptorProto());
            $this->assertInstanceOf(DescriptorProto::class, $schema->getProtoDescriptor());
        } else {
            $this->assertTrue(DescriptorFix::$is_initialized);
            $this->expectException(LogicException::class);
            $this->expectExceptionMessage('Proto2 classes are not supported');
            new DescriptorProto();
        }
    }

    public function testDescriptorFixSkippedWhenDescriptorProtoExists(): void
    {
        $wasInitialized = DescriptorFix::$is_initialized;
        DescriptorFix::$is_initialized = false;

        try {
            $this->assertTrue(class_exists(DescriptorProto::class));
            require __DIR__ . '/../../metadata/descriptor_fix.php';
            $this->assertFalse(DescriptorFix::$is_initialized);
        } finally {
            DescriptorFix::$is_initialized = $wasInitialized;
        }
    }
}
