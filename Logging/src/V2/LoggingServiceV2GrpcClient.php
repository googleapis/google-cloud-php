<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Logging\V2;

/**
 * Service for ingesting and querying logs.
 */
class LoggingServiceV2GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Deletes all the log entries in a log for the _Default Log Bucket. The log
     * reappears if it receives new entries. Log entries written shortly before
     * the delete operation might not be deleted. Entries received after the
     * delete operation with a timestamp before the operation will be deleted.
     * @param \Google\Cloud\Logging\V2\DeleteLogRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteLog(\Google\Cloud\Logging\V2\DeleteLogRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.LoggingServiceV2/DeleteLog',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Writes log entries to Logging. This API method is the
     * only way to send log entries to Logging. This method
     * is used, directly or indirectly, by the Logging agent
     * (fluentd) and all logging libraries configured to use Logging.
     * A single request may contain log entries for a maximum of 1000
     * different resources (projects, organizations, billing accounts or
     * folders)
     * @param \Google\Cloud\Logging\V2\WriteLogEntriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function WriteLogEntries(\Google\Cloud\Logging\V2\WriteLogEntriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.LoggingServiceV2/WriteLogEntries',
        $argument,
        ['\Google\Cloud\Logging\V2\WriteLogEntriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists log entries.  Use this method to retrieve log entries that originated
     * from a project/folder/organization/billing account.  For ways to export log
     * entries, see [Exporting
     * Logs](https://cloud.google.com/logging/docs/export).
     * @param \Google\Cloud\Logging\V2\ListLogEntriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLogEntries(\Google\Cloud\Logging\V2\ListLogEntriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.LoggingServiceV2/ListLogEntries',
        $argument,
        ['\Google\Cloud\Logging\V2\ListLogEntriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the descriptors for monitored resource types used by Logging.
     * @param \Google\Cloud\Logging\V2\ListMonitoredResourceDescriptorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMonitoredResourceDescriptors(\Google\Cloud\Logging\V2\ListMonitoredResourceDescriptorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.LoggingServiceV2/ListMonitoredResourceDescriptors',
        $argument,
        ['\Google\Cloud\Logging\V2\ListMonitoredResourceDescriptorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the logs in projects, organizations, folders, or billing accounts.
     * Only logs that have entries are listed.
     * @param \Google\Cloud\Logging\V2\ListLogsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLogs(\Google\Cloud\Logging\V2\ListLogsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.logging.v2.LoggingServiceV2/ListLogs',
        $argument,
        ['\Google\Cloud\Logging\V2\ListLogsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Streaming read of log entries as they are ingested. Until the stream is
     * terminated, it will continue reading logs.
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\BidiStreamingCall
     */
    public function TailLogEntries($metadata = [], $options = []) {
        return $this->_bidiRequest('/google.logging.v2.LoggingServiceV2/TailLogEntries',
        ['\Google\Cloud\Logging\V2\TailLogEntriesResponse','decode'],
        $metadata, $options);
    }

}
