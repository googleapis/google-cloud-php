<?php

namespace Google\Cloud\Spanner;

use Google\ApiCore\Serializer as ApiCoreSerializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Spanner\V1\PartialResultSet;
use Google\Cloud\Spanner\V1\Type;
use Google\Protobuf\Internal\RepeatedField as DeprecatedRepeatedField;
use Google\Protobuf\RepeatedField;
use Google\Protobuf\Struct;
use Google\Protobuf\Timestamp;
use Google\Protobuf\Value;

/**
 * Supplies helper methods to interact with the APIs.
 *
 * @internal
 */
class Serializer extends ApiCoreSerializer
{
    use ApiHelperTrait;

    private Serializer $serializer; // Self reference for ApiHelperTrait

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
            },
            'google.protobuf.Struct' => function ($v) {
                if (!isset($v['fields'])) {
                    return ['fields' => $v];
                }
                return $v;
            },
            'google.protobuf.Value' => function ($v) {
                if (!is_array($v) || (
                    !isset($v['nullValue']) &&
                  !isset($v['null_value']) &&
                  !isset($v['numberValue']) &&
                  !isset($v['number_value']) &&
                  !isset($v['stringValue']) &&
                  !isset($v['string_value']) &&
                  !isset($v['boolValue']) &&
                  !isset($v['bool_value']) &&
                  !isset($v['structValue']) &&
                  !isset($v['struct_value']) &&
                  !isset($v['listValue']) &&
                  !isset($v['list_value'])
                )) {
                    return $this->formatValueForApi($v);
                }
                return $v;
            },
            'google.spanner.v1.Mutation' => function ($v) {
                return $this->formatMutation($v);
            },
            'google.spanner.v1.TransactionOptions' => function ($v) {
                return $this->formatTransactionOptions($v);
            },
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

        $this->serializer = $this;
    }

    /**
     * Utility method to return "fields data" in the format:
     * [
     *   "name" => ""
     *   "type" => []
     * ].
     *
     * The type is converted from a string like INT64 to ["code" => 2, "typeAnnotation" => 0]
     * conforming with the Google\Cloud\Spanner\V1\TypeCode class.
     *
     * @param RepeatedField|DeprecatedRepeatedField|null $fields The array contain list of fields.
     *
     * @return array The formatted fields data.
     */
    private function getFieldDataFromRepeatedFields(RepeatedField|DeprecatedRepeatedField|null $fields): array
    {
        if (is_null($fields)) {
            return [];
        }

        $fieldsData = [];
        foreach ($fields as $key => $field) {
            $type = $field->getType();
            $typeData = $this->getTypeData($type);

            $fieldsData[$key] = [
                'name' => $field->getName(),
                'type' => $typeData
            ];
        }

        return $fieldsData;
    }

    /**
     * Utiltiy method to take in a Google\Cloud\Spanner\V1\Type value and return
     * the data as an array. The method takes care of array and struct elements.
     *
     * @param Type $type The "type" object
     *
     * @return array The formatted data.
     */
    private function getTypeData(Type $type): array
    {
        $data = [
            'code' => $type->getCode(),
            'typeAnnotation' => $type->getTypeAnnotation(),
            'protoTypeFqn' => $type->getProtoTypeFqn()
        ];

        // If this is a struct field, then recursisevly call getTypeData
        if ($type->hasStructType()) {
            $nestedType = $type->getStructType();
            $fields = $nestedType->getFields();
            $data['structType'] = [
                'fields' => $this->getFieldDataFromRepeatedFields($fields)
            ];
        }
        // If this is an array field, then recursisevly call getTypeData
        if ($type->hasArrayElementType()) {
            $nestedType = $type->getArrayElementType();
            $data['arrayElementType'] = $this->getTypeData($nestedType);
        }

        return $data;
    }

    private function formatMutation(array $mutation): array
    {
        if (!$mutation) {
            return [];
        }
        $type = array_keys($mutation)[0];
        $data = $mutation[$type];
        switch ($type) {
            case Operation::OP_DELETE:
                // no-op
                break;
            default:
                $modifiedData = array_map([$this, 'formatValueForApi'], $data['values']);
                $data['values'] = [['values' => $modifiedData]];
                break;
        }

        return [$type => $data];
    }

    /**
     * @param array $transactionOptions
     * @return array
     */
    private function formatTransactionOptions(array $transactionOptions): array
    {
        // sometimes readOnly is a PBReadOnly message instance
        if (isset($transactionOptions['readOnly']) && is_array($transactionOptions['readOnly'])) {
            $ro = $transactionOptions['readOnly'];
            if (isset($ro['minReadTimestamp'])) {
                $ro['minReadTimestamp'] =
                    $this->formatTimestampForApi($ro['minReadTimestamp']);
            }

            if (isset($ro['readTimestamp'])) {
                $ro['readTimestamp'] =
                    $this->formatTimestampForApi($ro['readTimestamp']);
            }

            $transactionOptions['readOnly'] = $ro;
        }

        return $transactionOptions;
    }
}
