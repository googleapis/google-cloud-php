<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/chat/v1/user.proto

namespace GPBMetadata\Google\Chat\V1;

class User
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
�
google/chat/v1/user.protogoogle.chat.v1"�
User
name (	
display_name (	B�A
	domain_id (	\'
type (2.google.chat.v1.User.Type
is_anonymous (B�A"0
Type
TYPE_UNSPECIFIED 	
HUMAN
BOTB�
com.google.chat.v1B	UserProtoPZ,cloud.google.com/go/chat/apiv1/chatpb;chatpb�DYNAPIProto�Google.Apps.Chat.V1�Google\\Apps\\Chat\\V1�Google::Apps::Chat::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

