<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/bigtable/v2/feature_flags.proto

namespace GPBMetadata\Google\Bigtable\V2;

class FeatureFlags
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
&google/bigtable/v2/feature_flags.protogoogle.bigtable.v2"�
FeatureFlags
reverse_scans (
mutate_rows_rate_limit (
mutate_rows_rate_limit2 ("
last_scanned_row_responses (
routing_cookie (

retry_info (#
client_side_metrics_enabled ( 
traffic_director_enabled	 (
direct_access_requested
 (B�
com.google.bigtable.v2BFeatureFlagsProtoPZ8cloud.google.com/go/bigtable/apiv2/bigtablepb;bigtablepb�Google.Cloud.Bigtable.V2�Google\\Cloud\\Bigtable\\V2�Google::Cloud::Bigtable::V2bproto3'
        , true);

        static::$is_initialized = true;
    }
}

