<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore;

use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;

/**
 * Utility methods mostly for translating data from user input to API format.
 */
trait DatastoreTrait
{
    /**
     * Format the partitionId
     *
     * @param string $projectId
     * @param array $options {
     *     Partition ID Options
     *
     *     @type string $namespaceId The namespace ID, if set.
     * }
     * @return array
     */
    private function partitionId($projectId, array $options = [])
    {
        $options = $options + [
            'namespaceId' => null
        ];

        return [
            'projectId' => $projectId,
            'namespaceId' => $options['namespaceId']
        ];
    }

    /**
     * Format the readOptions
     *
     * @param array $options {
     *      Read Options
     *
     *      @type Transaction $transaction If set to an instance of {@see Transaction},
     *            run the operation in that transaction.
     *      @type string $readConsistency If not in a transaction, set to STRONG
     *            or EVENTUAL, depending on default value in DatastoreClient.
     * }
     * @return array
     */
    private function readOptions(array $options = [])
    {
        $options = $options + [
            'readConsistency' => DatastoreClient::DEFAULT_READ_CONSISTENCY,
            'transaction' => null
        ];

        if ($options['transaction'] && $options['transaction'] instanceof Transaction) {
            return [
                'transaction' => $options['transaction']->id()
            ];
        }

        return [
            'readConsistency' => $options['readConsistency']
        ];
    }

    /**
     * Format values for the API
     *
     * @param mixed $value
     * @param bool $encode Set to true to base64_encode certain values
     * @return array
     */
    private function valueObject($value, $encode = false)
    {
        switch (gettype($value)) {
            case "boolean":
                $propertyValue = [
                    "booleanValue" => $value
                ];

                break;
            case "integer":
                $propertyValue = [
                    "integerValue" => $value
                ];

                break;
            case "double":
                $propertyValue = [
                    "doubleValue" => $value
                ];

                break;
            case "string":
                $propertyValue = [
                    "stringValue" => $value
                ];

                break;
            case "array":
                $values = [];
                foreach ($value as $key => $val) {
                    $values[$key] = $this->valueObject($val, $encode);
                }

                $propertyValue = [
                    "arrayValue" => [
                        "values" => $values
                    ]
                ];
                break;
            case "object":
                $propertyValue = $this->objectProperty($value);
                break;
            case "resource":
                $content = stream_get_contents($value);

                $propertyValue = [
                    "blobValue" => ($encode)
                        ? base64_encode($content)
                        : $content
                ];
                break;
            case "NULL":
                $propertyValue = [
                    "nullValue" => null
                ];
                break;
            //@codeCoverageIgnoreStart
            case "unknown type":
                $propertyValue = '';
                break;
            default:
                $propertyValue = '';
                break;
            //@codeCoverageIgnoreEnd
        }

        return $propertyValue;
    }

    /**
     * Convert different object types to API values
     *
     * @todo add middleware
     *
     * @param mixed $value
     * @param bool $encode
     * @return array
     */
    private function objectProperty($value, $encode = false)
    {
        if ($value instanceof \DateTimeInterface) {
            return [
                "timestampValue" => $value->format(\DateTime::RFC3339)
            ];
        }

        throw new InvalidArgumentException(
            sprintf('Value of type `%s` could not be serialize', get_class($value))
        );
    }

    /**
     * Determine whether given array is associative
     *
     * @param array $value
     * @return bool
     */
    private function isAssoc(array $value)
    {
        return array_keys($value) !== range(0, count($value) - 1);
    }

    /**
     * Check that each member of $input array is of type $type.
     *
     * @param array $input The input to validate
     * @param string $type The type to check.
     * @param callable An additional check for each element of $input.
     *        This will be run count($input) times, so use with care.
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateBatch(
        array $input,
        $type,
        callable $additionalCheck = null
    ) {
        foreach ($input as $element) {
            if (!($element instanceof $type)) {
                throw new InvalidArgumentException(sprintf(
                    'Each member of input array must be an instance of %s',
                    $type
                ));
            }

            if ($additionalCheck) {
                $additionalCheck($element);
            }
        }
    }
}
