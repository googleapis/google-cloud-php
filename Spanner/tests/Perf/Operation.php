<?php
/**
 * Copyright 2019 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Spanner\Tests\Perf;

use Google\Cloud\Spanner\Database;

class Operation
{
    /**
     * @var string
     */
    private $database;

    /**
     * @var array
     */
    private $parameters;

    /**
     * float
     */
    private $totalWeight;

    /**
     * @var array
     */
    private $weights;

    /**
     * @var array
     */
    private $operations;

    /**
     * @var array
     */
    private $latency;

    /**
     * @var array
     */
    private $keys;

    /**
     * @param string $database
     * @param array $parameters
     * @param float $totalWeight
     * @param array $weights
     * @param array $operations
     * @param array $latency
     */
    public function __construct(
        $database,
        array $parameters,
        $totalWeight,
        array $weights,
        array $operations,
        array $latency
    ) {
        $this->database = $database;
        $this->parameters = $parameters;
        $this->totalWeight = $totalWeight;
        $this->weights = $weights;
        $this->operations = $operations;
        $this->latency = $latency;
    }

    public function load()
    {
        $this->keys = [];

        $startTime = microtime(true);
        $snapshot = $this->database->snapshot();

        // Kind of assuming that id is always name of PK in whatever table you choose
        $results = $snapshot->execute('SELECT id FROM ' . $this->parameters['table']);
        foreach ($results as $row) {
            $this->keys[] = $row['id'];
        }

        return microtime(true) - $startTime;
    }

    /**
     * Run a single thread of the workload
     *
     * @return void
     */
    public function run()
    {
        if (!is_array($this->keys)) {
            throw new \RuntimeException('Call Operation::load() first.');
        }

        $operationCount = (int) $this->parameters['operationcount'];
        for ($i = 0; $i < $operationCount; $i++) {
            $weight = (float) rand(0, $this->totalWeight * 10000) / 10000.0;

            for ($j = 0; $j < count($this->weights); $j++) {
                if ($weight <= $this->weights[$j]) {
                    $operation = $this->operations[$j];

                    $this->latency[$operation][] = $this->runOperation(
                        $this->database,
                        $this->parameters['table'],
                        $operation
                    );
                    break;
                }
            }
        }

        return $this->latency;
    }

    /**
     * Executes an operation.
     *
     * @param string $database
     * @param string $table
     * @param array $operation
     * @return void
     */
    private function runOperation($database, $table, $operation)
    {
        $key = $this->keys[array_rand($this->keys)];
        switch ($operation) {
            case 'read':
                $optime = $this->performRead($database, $table, $key);
                break;
            case 'update':
                $optime = $this->update($database, $table, $key);
                break;
            case 'insert':
                $optime = $this->insert($database, $table);
                break;
            case 'scan':
                $optime = $this->scan($database, $table, $key);
                break;
        }

        return $optime;
    }

    /**
     * Executes a read.
     *
     * @param string $database
     * @param string $table
     * @param string $key
     * @return float Time elapsed.
     */
    private function performRead($database, $table, $key)
    {
        $startTime = microtime(true);

        // Kind of assuming that id is ubiquitous...
        $results = $database->execute('SELECT * FROM ' . $table . ' where id = @id', [
            'parameters' => [
                'id' => $key
            ]
        ]);

        foreach ($results as $row) {
            $key = $row;
        }

        return microtime(true) - $startTime;
    }

    /**
     * Executes a single update.
     *
     * @param string $database
     * @param string $table
     * @param string $key
     * @return float Time elapsed.
     */
    private function update($database, $table, $key)
    {
        // Does a single update operation.
        $field = rand(0, 9);
        $startTime = microtime(true);

        $operation = $database->transaction(['singleUse' => false])
            ->update($table, [
                'id' => $key,
                'field' . $field => $this->randString(false, 100)
            ])->commit();

        return microtime(true) - $startTime;
    }

    /**
     * Inserts a row
     *
     * @param string $database
     * @param string $table
     * @return float Time elapsed.
     */
    private function insert($database, $table)
    {
        $batch = [];  //array of $arrFields
        $fields = [];
        $fields['id'] = 'user4' . $this->randString(true, 17);

        for ($f = 0; $f < 10; $f++) {
            $fields['field' . $f] = $this->randString(false, 100);
        }

        $batch[] = $fields;
        array_multisort($batch);

        $startTime = microtime(true);
        $operation = $database->transaction(['singleUse' => true])
            ->insertBatch($table, $batch)
            ->commit();

        return microtime(true) - $startTime;
    }

    /**
     * Not Implemented.
     *
     * @param string $database
     * @param string $table
     * @param string $key
     * @return float
     */
    private function scan($database, $table, $key)
    {
        // not implemented.
        return 0.0;
    }

    private function randString($num, $len)
    {
        $strRand = "";
        if ($num == true) {
            $characters = '0123456789';
        } else {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $charlen = strlen($characters);
        for ($i = 0; $i < $len; $i++) {
            $strRand .= $characters[rand(0, $charlen - 1)];
        }

        return $strRand;
    }
}
