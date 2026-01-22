<?php
/*
 * Copyright 2025 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\ApiCore;

class KnownTypes
{
    private static bool $initialized = false;

    public const GRPC_TYPES = [
        'google.rpc.retryinfo-bin' => \Google\Rpc\RetryInfo::class,
        'google.rpc.debuginfo-bin' => \Google\Rpc\DebugInfo::class,
        'google.rpc.quotafailure-bin' => \Google\Rpc\QuotaFailure::class,
        'google.rpc.badrequest-bin' => \Google\Rpc\BadRequest::class,
        'google.rpc.requestinfo-bin' => \Google\Rpc\RequestInfo::class,
        'google.rpc.resourceinfo-bin' => \Google\Rpc\ResourceInfo::class,
        'google.rpc.errorinfo-bin' => \Google\Rpc\ErrorInfo::class,
        'google.rpc.help-bin' => \Google\Rpc\Help::class,
        'google.rpc.localizedmessage-bin' => \Google\Rpc\LocalizedMessage::class,
        'google.rpc.preconditionfailure-bin' => \Google\Rpc\PreconditionFailure::class,
    ];

    public const JSON_TYPES = [
        'type.googleapis.com/google.rpc.RetryInfo' => \Google\Rpc\RetryInfo::class,
        'type.googleapis.com/google.rpc.DebugInfo' => \Google\Rpc\DebugInfo::class,
        'type.googleapis.com/google.rpc.QuotaFailure' => \Google\Rpc\QuotaFailure::class,
        'type.googleapis.com/google.rpc.BadRequest' => \Google\Rpc\BadRequest::class,
        'type.googleapis.com/google.rpc.RequestInfo' => \Google\Rpc\RequestInfo::class,
        'type.googleapis.com/google.rpc.ResourceInfo' => \Google\Rpc\ResourceInfo::class,
        'type.googleapis.com/google.rpc.ErrorInfo' => \Google\Rpc\ErrorInfo::class,
        'type.googleapis.com/google.rpc.Help' => \Google\Rpc\Help::class,
        'type.googleapis.com/google.rpc.LocalizedMessage' => \Google\Rpc\LocalizedMessage::class,
        'type.googleapis.com/google.rpc.PreconditionFailure' => \Google\Rpc\PreconditionFailure::class,
    ];

    public static function allKnownTypes(): array
    {
        return self::GRPC_TYPES + self::JSON_TYPES;
    }

    public static function addKnownTypesToDescriptorPool()
    {
        if (self::$initialized) {
            return;
        }

        // adds all the above protobuf classes to the descriptor pool
        \GPBMetadata\Google\Rpc\ErrorDetails::initOnce();
        self::$initialized = true;
    }
}
