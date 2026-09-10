<?php

/*
 * Copyright 2026 Google LLC
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

namespace Google\ApiCore\Telemetry;

/**
 * Standard OpenTelemetry span attribute names used across Google Cloud PHP client libraries.
 */
final class SpanAttributes
{
    // RPC & Transport attributes
    public const RPC_METHOD = 'rpc.method';
    public const RPC_SYSTEM_NAME = 'rpc.system.name';
    /** @deprecated Use RPC_SYSTEM_NAME instead */
    public const RPC_SYSTEM = 'rpc.system.name';
    public const RPC_RESPONSE_STATUS_CODE = 'rpc.response.status_code';

    // HTTP & Network attributes
    public const HTTP_REQUEST_METHOD = 'http.request.method';
    public const HTTP_RESPONSE_STATUS_CODE = 'http.response.status_code';
    public const HTTP_REQUEST_RESEND_COUNT = 'http.request.resend_count';
    public const SERVER_ADDRESS = 'server.address';
    public const SERVER_PORT = 'server.port';
    public const URL_FULL = 'url.full';
    public const URL_DOMAIN = 'url.domain';
    public const URL_TEMPLATE = 'url.template';

    // Error & Exception attributes
    public const ERROR_TYPE = 'error.type';
    public const EXCEPTION_TYPE = 'exception.type';
    public const STATUS_MESSAGE = 'status.message';
}
