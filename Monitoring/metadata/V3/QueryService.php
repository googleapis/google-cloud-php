<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/query_service.proto

namespace GPBMetadata\Google\Monitoring\V3;

class QueryService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Monitoring\V3\MetricService::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
(google/monitoring/v3/query_service.protogoogle.monitoring.v3google/api/client.proto)google/monitoring/v3/metric_service.proto2�
QueryService�
QueryTimeSeries,.google.monitoring.v3.QueryTimeSeriesRequest-.google.monitoring.v3.QueryTimeSeriesResponse"4����+"&/v3/{name=projects/*}/timeSeries:query:*��Amonitoring.googleapis.com�A�https://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/monitoring,https://www.googleapis.com/auth/monitoring.readB�
com.google.monitoring.v3BQueryServiceProtoPZAcloud.google.com/go/monitoring/apiv3/v2/monitoringpb;monitoringpb�Google.Cloud.Monitoring.V3�Google\\Cloud\\Monitoring\\V3�Google::Cloud::Monitoring::V3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

