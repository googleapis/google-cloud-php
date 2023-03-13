<?php

/**
 * IMPORTANT: This file is to prevent the following error from being thrown in this library when
 * the native PHP protobuf library is used:
 *
 *   "proto not added: google.protobuf.DescriptorProto for google.cloud.bigquery.storage.v1.ProtoSchema"
 *
 * This file can be removed once a fix is implemented in the protobuf library
 * @see https://github.com/protocolbuffers/protobuf/issues/11649
 */
namespace GPBMetadata\Google\Protobuf;

class DescriptorFix
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }

        // add a no-op reference for "google.protobuf.DescriptorProto"
        $pool->addMessage('google.protobuf.DescriptorProto', \Google\Protobuf\Internal\Message::class)->finalizeToPool();
        static::$is_initialized = true;
    }
}

DescriptorFix::initOnce();

