<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/api/label.proto

namespace GPBMetadata\Google\Api;

class Label
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
google/api/label.proto
google.api"�
LabelDescriptor
key (	9

value_type (2%.google.api.LabelDescriptor.ValueType
description (	",
	ValueType

STRING 
BOOL	
INT64B\\
com.google.apiB
LabelProtoPZ5google.golang.org/genproto/googleapis/api/label;label�GAPIbproto3'
        , true);

        static::$is_initialized = true;
    }
}

