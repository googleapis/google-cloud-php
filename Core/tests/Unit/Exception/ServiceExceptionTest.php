<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit\Exception;

use Google\ApiCore\ApiException;
use Google\Cloud\Core\Exception\ServiceException;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 * @group exception
 */
class ServiceExceptionTest extends TestCase
{
    public function testHasServiceException()
    {
        $previous = new \Exception('test');

        $ex = new ServiceException('foo', 123, $previous);
        $this->assertTrue($ex->hasServiceException());

        $this->assertEquals($previous, $ex->getServiceException());
    }

    public function testDoesntHaveServiceException()
    {
        $ex = new ServiceException('foo');
        $this->assertFalse($ex->hasServiceException());
    }

    public function testGetErrorInfoMetadataWithGrpc()
    {
        $metadata = [
            'ackId1' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'ackId2' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $errorInfoRow = [
            '@type' => 'google.rpc.errorinfo-bin',
            'reason' => 'EXACTLY_ONCE_ACKID_FAILURE',
            'domain' => 'pubsub.googleapis.com',
            'metadata' => $metadata
        ];

        $debugRow = [
            '@type' => 'google.rpc.debuginfo-bin',
            'detail' => 'EXACTLY_ONCE_ACKID_FAILURE'
        ];

        // Valid json containing error details
        $msg = [
            'details' => [
                $errorInfoRow, $debugRow
            ]
        ];

        $apiEx = new ApiException(json_encode($msg), 400, 'INVALID_ARGUMENT', ['metadata' => [
            $errorInfoRow, $debugRow
        ]]);

        $ex = new ServiceException(json_encode($msg), 400, $apiEx);

        $this->assertEquals($metadata, $ex->getErrorInfoMetadata());
    }

    public function testGetErrorInfoMetadataWithRest()
    {
        $metadata = [
            'ackId1' => 'PERMANENT_FAILURE_INVALID_ACK_ID',
            'ackId2' => 'PERMANENT_FAILURE_INVALID_ACK_ID'
        ];

        $errorInfoRow = [
            '@type' => 'type.googleapis.com/google.rpc.ErrorInfo',
            'reason' => 'EXACTLY_ONCE_ACKID_FAILURE',
            'domain' => 'pubsub.googleapis.com',
            'metadata' => $metadata
        ];

        $debugRow = [
            '@type' => 'type.googleapis.com/google.rpc.DebugInfo',
            'detail' => ''
        ];
        
        // Valid json containing error details
        $msg = [
            'error' => [
                'details' => [
                    $errorInfoRow, $debugRow
                ]
            ]
        ];

        $ex = new ServiceException(json_encode($msg));

        $this->assertEquals($metadata, $ex->getErrorInfoMetadata());
    }

    public function testGetErrorInfoMetadataOnInvalidJson()
    {
        // Invalid json
        $msg = '{';

        $ex = new ServiceException($msg);

        $this->assertEquals([], $ex->getErrorInfoMetadata());
    }

    public function testGetErrorInfoMetadataOnNoDetails()
    {
        // Valid json but not containing error details
        $msg = [
            'error' => []
        ];

        $ex = new ServiceException(json_encode($msg));

        $this->assertEquals([], $ex->getErrorInfoMetadata());
    }

    public function testGetReasonWithGrpc()
    {
        $reason = 'EXACTLY_ONCE_ACKID_FAILURE';

        $errorInfoRow = [
            '@type' => 'google.rpc.errorinfo-bin',
            'reason' => $reason,
            'domain' => 'pubsub.googleapis.com',
            'metadata' => []
        ];

        $debugRow = [
            '@type' => 'google.rpc.debuginfo-bin',
            'detail' => 'EXACTLY_ONCE_ACKID_FAILURE'
        ];

        // Valid json containing error details
        $msg = [
            'details' => [
                $errorInfoRow, $debugRow
            ]
        ];

        $apiEx = new ApiException(json_encode($msg), 400, 'INVALID_ARGUMENT', ['metadata' => [
            $errorInfoRow, $debugRow
        ]]);

        $ex = new ServiceException(json_encode($msg), 400, $apiEx);

        $this->assertEquals($reason, $ex->getReason());
    }

    public function testGetReasonWithRest()
    {
        $reason = 'EXACTLY_ONCE_ACKID_FAILURE';

        $errorInfoRow = [
            '@type' => 'type.googleapis.com/google.rpc.ErrorInfo',
            'reason' => $reason,
            'domain' => 'pubsub.googleapis.com',
            'metadata' => []
        ];

        $debugRow = [
            '@type' => 'type.googleapis.com/google.rpc.DebugInfo',
            'detail' => ''
        ];
        
        // Valid json containing error details
        $msg = [
            'error' => [
                'details' => [
                    $errorInfoRow, $debugRow
                ]
            ]
        ];

        $ex = new ServiceException(json_encode($msg));

        $this->assertEquals($reason, $ex->getReason());
    }

    public function testGetReasonOnInvalidJson()
    {
        // Invalid json
        $msg = '{';

        $ex = new ServiceException($msg);

        $this->assertEquals('', $ex->getReason());
    }

    public function testGetReasonOnNoDetails()
    {
        // Valid json but not containing error details
        $msg = [
            'error' => []
        ];

        $ex = new ServiceException(json_encode($msg));

        $this->assertEquals('', $ex->getReason());
    }
}
