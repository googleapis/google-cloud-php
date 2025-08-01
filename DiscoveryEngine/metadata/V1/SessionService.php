<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/session_service.proto

namespace GPBMetadata\Google\Cloud\Discoveryengine\V1;

class SessionService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\ConversationalSearchService::initOnce();
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\Session::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
5google/cloud/discoveryengine/v1/session_service.protogoogle.cloud.discoveryengine.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.protoCgoogle/cloud/discoveryengine/v1/conversational_search_service.proto-google/cloud/discoveryengine/v1/session.protogoogle/protobuf/empty.proto2�
SessionService�
CreateSession5.google.cloud.discoveryengine.v1.CreateSessionRequest(.google.cloud.discoveryengine.v1.Session"��Aparent,session����"9/v1/{parent=projects/*/locations/*/dataStores/*}/sessions:sessionZR"G/v1/{parent=projects/*/locations/*/collections/*/dataStores/*}/sessions:sessionZO"D/v1/{parent=projects/*/locations/*/collections/*/engines/*}/sessions:session�
DeleteSession5.google.cloud.discoveryengine.v1.DeleteSessionRequest.google.protobuf.Empty"��Aname����*9/v1/{name=projects/*/locations/*/dataStores/*/sessions/*}ZI*G/v1/{name=projects/*/locations/*/collections/*/dataStores/*/sessions/*}ZF*D/v1/{name=projects/*/locations/*/collections/*/engines/*/sessions/*}�
UpdateSession5.google.cloud.discoveryengine.v1.UpdateSessionRequest(.google.cloud.discoveryengine.v1.Session"��Asession,update_mask����2A/v1/{session.name=projects/*/locations/*/dataStores/*/sessions/*}:sessionZZ2O/v1/{session.name=projects/*/locations/*/collections/*/dataStores/*/sessions/*}:sessionZW2L/v1/{session.name=projects/*/locations/*/collections/*/engines/*/sessions/*}:session�

GetSession2.google.cloud.discoveryengine.v1.GetSessionRequest(.google.cloud.discoveryengine.v1.Session"��Aname����9/v1/{name=projects/*/locations/*/dataStores/*/sessions/*}ZIG/v1/{name=projects/*/locations/*/collections/*/dataStores/*/sessions/*}ZFD/v1/{name=projects/*/locations/*/collections/*/engines/*/sessions/*}�
ListSessions4.google.cloud.discoveryengine.v1.ListSessionsRequest5.google.cloud.discoveryengine.v1.ListSessionsResponse"��Aparent����9/v1/{parent=projects/*/locations/*/dataStores/*}/sessionsZIG/v1/{parent=projects/*/locations/*/collections/*/dataStores/*}/sessionsZFD/v1/{parent=projects/*/locations/*/collections/*/engines/*}/sessionsR�Adiscoveryengine.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
#com.google.cloud.discoveryengine.v1BSessionServiceProtoPZMcloud.google.com/go/discoveryengine/apiv1/discoveryenginepb;discoveryenginepb�DISCOVERYENGINE�Google.Cloud.DiscoveryEngine.V1�Google\\Cloud\\DiscoveryEngine\\V1�"Google::Cloud::DiscoveryEngine::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

