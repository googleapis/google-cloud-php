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

class Config
{
    private $sapi;

    private $parameters = [
        "operationcount",
        "instance",
        "database",
        "table",
        "workload",
    ];

    public static $operations = [
        'readproportion',
        'updateproportion',
        'scanproportion',
        'insertproportion'
    ];

    private function __construct($sapi)
    {
        $this->sapi = $sapi;
    }

    public static function getParameters()
    {
        $config = new self(php_sapi_name());
        return $config->parseInputParams();
    }

    public function parseInputParams()
    {
        switch ($this->sapi) {
            case 'cli':
                return $this->parseCliInputParams();
                break;
            case 'default':
                return $this->parseQueryStringInputParams();
                break;
        }
    }

    private function parseCliInputParams()
    {
        $parameters = getopt("", array_map(function ($paramName) {
            return $paramName . ':';
        }, $this->parameters));

        return $this->loadWorkloadFile($parameters, $parameters['workload']);
    }

    private function parseQueryStringInputParams()
    {
        $parameters = [];
        foreach ($this->parameters as $param) {
            if (!isset($_GET[$param])) {
                throw new \RuntimeException('Missing '. $param);
            }

            $parameters[$param] = $_GET[$param];
        }

        return $this->loadWorkloadFile($parameters, $parameters['workload']);
    }

    private function loadWorkloadFile(array $parameters, $path)
    {
        if (!file_exists($path)) {
            throw new \RuntimeException('Unable to load file from ' . $path);
        }

        foreach (explode(PHP_EOL, file_get_contents($path)) as $line) {
            $parts = explode("=", $line);
            $key = trim($parts[0]);

            if (in_array($key, self::$operations)) {
                $parameters[$key] = trim($parts[1]);
            }
        }

        return $parameters;
    }
}
