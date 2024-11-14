<?php

namespace Google\Cloud\Spanner;

use Google\ApiCore\Serializer as ApiCoreSerializer;
use Google\Cloud\Core\ApiHelperTrait;

/**
 * @internal
 * Supplies helper methods to interact with the APIs.
 */
class Serializer extends ApiCoreSerializer
{
    use ApiHelperTrait;

    public function __construct()
    {
        $fieldTransformers = [];
        $messageTypeTransformers = [
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
        $decodeFieldTransformers = [];
        $decodeMessageTypeTransformers = [
            'google.spanner.v1.KeySet' => function ($keySet) {
                $keys = $this->pluck('keys', $keySet, false);
                if ($keys) {
                    $keySet['keys'] = array_map(
                        fn ($key) => $this->formatListForApi((array) $key),
                        $keys
                    );
                }

                if (isset($keySet['ranges'])) {
                    $keySet['ranges'] = array_map(function ($rangeItem) {
                        return array_map([$this, 'formatListForApi'], $rangeItem);
                    }, $keySet['ranges']);

                    if (empty($keySet['ranges'])) {
                        unset($keySet['ranges']);
                    }
                }

                return $keySet;
            }
        ];
        $customEncoders = [
            // A custom encoder that short-circuits the encodeMessage in Serializer class,
            // but only if the argument is of the type PartialResultSet.
            PartialResultSet::class => function ($msg) {
                $data = json_decode($msg->serializeToJsonString(), true);

                // We only override metadata fields, if it actually exists in the response.
                // This is specially important for large data sets which is received in chunks.
                // Metadata is only received in the first 'chunk' and we don't want to set empty metadata fields
                // when metadata was not returned from the server.
                if (isset($data['metadata'])) {
                    // The transaction id is serialized as a base64 encoded string in $data. So, we
                    // add a step to get the transaction id using a getter instead of the serialized value.
                    // The null-safe operator is used to handle edge cases where the relevant fields are not present.
                    $data['metadata']['transaction']['id'] = (string) $msg?->getMetadata()?->getTransaction()?->getId();

                    // Helps convert metadata enum values from string types to their respective code/annotation
                    // pairs. Ex: INT64 is converted to {code: 2, typeAnnotation: 0}.
                    $fields = $msg->getMetadata()?->getRowType()?->getFields();
                    $data['metadata']['rowType']['fields'] = $this->getFieldDataFromRepeatedFields($fields);
                }

                // These fields in stats should be an int
                if (isset($data['stats']['rowCountLowerBound'])) {
                    $data['stats']['rowCountLowerBound'] = (int) $data['stats']['rowCountLowerBound'];
                }
                if (isset($data['stats']['rowCountExact'])) {
                    $data['stats']['rowCountExact'] = (int) $data['stats']['rowCountExact'];
                }

                return $data;
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