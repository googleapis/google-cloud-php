<?php

namespace Google\Cloud\Core;

use Google\ApiCore\Serializer as ApiCoreSerializer;
use Google\Cloud\Core\ApiHelperTrait;

/**
 * @internal
 * Supplies helper methods to interact with the APIs.
 */
class Serializer extends ApiCoreSerializer
{
    use ApiHelperTrait;

    public function __construct(
        $fieldTransformers = [],
        $messageTypeTransformers = [],
        $decodeFieldTransformers = [],
        $decodeMessageTypeTransformers = [],
        $customEncoders = [],
    ) {
        $messageTypeTransformers += [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ];

        parent::__construct(
            $fieldTransformers,
            $messageTypeTransformers,
            $decodeFieldTransformers,
            $decodeMessageTypeTransformers,
            $customEncoders,
        );
    }
}