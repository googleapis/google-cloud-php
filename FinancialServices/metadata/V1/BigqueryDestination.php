<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/financialservices/v1/bigquery_destination.proto

namespace GPBMetadata\Google\Cloud\Financialservices\V1;

class BigqueryDestination
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
<google/cloud/financialservices/v1/bigquery_destination.proto!google.cloud.financialservices.v1"�
BigQueryDestination
	table_uri (	B�Ag
write_disposition (2G.google.cloud.financialservices.v1.BigQueryDestination.WriteDispositionB�A"Z
WriteDisposition!
WRITE_DISPOSITION_UNSPECIFIED 
WRITE_EMPTY
WRITE_TRUNCATEB�
%com.google.cloud.financialservices.v1BBigQueryDestinationProtoPZScloud.google.com/go/financialservices/apiv1/financialservicespb;financialservicespb�!Google.Cloud.FinancialServices.V1�!Google\\Cloud\\FinancialServices\\V1�$Google::Cloud::FinancialServices::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

