<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace;

/**
 * This plain PHP class provides constants for common and reserved labels
 * special to Stackdriver Trace.
 */
class Labels
{
    const AGENT = '/agent';
    const COMPONENT = '/component';
    const ERROR_MESSAGE = '/error/message';
    const ERROR_NAME = '/error/name';
    const HTTP_CLIENT_CITY = '/http/client_city';
    const HTTP_CLIENT_COUNTRY = '/http/client_country';
    const HTTP_CLIENT_PROTOCOL = '/http/client_protocol';
    const HTTP_CLIENT_REGION = '/http/client_region';
    const HTTP_HOST = '/http/host';
    const HTTP_METHOD = '/http/method';
    const HTTP_REDIRECTED_URL = '/http/redirected_url';
    const HTTP_REQUEST_SIZE = '/http/request/size';
    const HTTP_RESPONSE_SIZE = '/http/response/size';
    const HTTP_STATUS_CODE = '/http/status_code';
    const HTTP_URL = '/http/url';
    const HTTP_USER_AGENT = '/http/user_agent';
    const PID = '/pid';
    const STACKTRACE = '/stacktrace';
    const TID = '/tid';

    const GAE_APPLICATION_ERROR = 'g.co/gae/application_error';
    const GAE_APP_MODULE = 'g.co/gae/app/module';
    const GAE_APP_MODULE_VERSION = 'g.co/gae/app/module_version';
    const GAE_APP_VERSION = 'g.co/gae/app/version';
    const GAE_DATASTORE_COUNT = 'g.co/gae/datastore/count';
    const GAE_DATASTORE_CURSOR = 'g.co/gae/datastore/cursor';
    const GAE_DATASTORE_ENTITY_WRITES = 'g.co/gae/datastore/entity_writes';
    const GAE_DATASTORE_HAS_ANCESTOR = 'g.co/gae/datastore/has_ancestor';
    const GAE_DATASTORE_HAS_CURSOR = 'g.co/gae/datastore/has_cursor';
    const GAE_DATASTORE_HAS_TRANSACTION = 'g.co/gae/datastore/has_transaction';
    const GAE_DATASTORE_INDEX_WRITES = 'g.co/gae/datastore/index_writes';
    const GAE_DATASTORE_KIND = 'g.co/gae/datastore/kind';
    const GAE_DATASTORE_LIMIT = 'g.co/gae/datastore/limit';
    const GAE_DATASTORE_MORE_RESULTS = 'g.co/gae/datastore/more_results';
    const GAE_DATASTORE_OFFSET = 'g.co/gae/datastore/offset';
    const GAE_DATASTORE_REQUESTED_ENTITY_DELETES = 'g.co/gae/datastore/requested_entity_deletes';
    const GAE_DATASTORE_REQUESTED_ENTITY_PUTS = 'g.co/gae/datastore/requested_entity_puts';
    const GAE_DATASTORE_SIZE = 'g.co/gae/datastore/size';
    const GAE_DATASTORE_SKIPPED = 'g.co/gae/datastore/skipped';
    const GAE_DATASTORE_TRANSACTION_HANDLE = 'g.co/gae/datastore/transaction_handle';
    const GAE_ERROR_MESSAGE = 'g.co/gae/error_message';
    const GAE_MEMCACHE_COUNT = 'g.co/gae/memcache/count';
    const GAE_MEMCACHE_SIZE = 'g.co/gae/memcache/size';
    const GAE_REQUEST_LOG_ID = 'g.co/gae/request_log_id';
}
