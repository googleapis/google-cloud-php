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

class Report
{
    private $sapi;

    private $message = '';

    public function __construct($sapi)
    {
        $this->sapi = $sapi;
    }

    public static function getReporter()
    {
        return new self(\php_sapi_name());
    }

    public function report($message)
    {
        if ($this->sapi === 'cli') {
            print $message;
        } else {
            // Otherwise, if it is being called from a browser, aggregate into a message.
            $this->message .= $message;
        }
    }

    public function aggregateMetrics(array $latency, $duration)
    {
        $overallOpCount = 0;
        $oppCounts = [];

        foreach ($latency as $opKey => $arrDurations) {
            $oppCounts[$opKey] = \count($arrDurations);
            $overallOpCount += $oppCounts[$opKey];
        }

        $this->report(\sprintf(
            '[OVERALL] Throughput (Ops/sec), %s' . PHP_EOL,
            $overallOpCount / $duration
        ));

        $template = '[%s], %s: %s.' . PHP_EOL;
        foreach ($oppCounts as $opKey => $intOpCounts) {
            $strUpperOp = \strtoupper($opKey);

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                'Operations',
                $intOpCounts
            ));

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                'AverageLatency(us)',
                $this->average($latency[$opKey])
            ));

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                'LatencyVariance(us)',
                $this->standardDeviation($latency[$opKey])
            ));

            $minLatency = $latency[$opKey]
                ? \min($latency[$opKey])
                : 0;
            $this->report(\sprintf(
                $template,
                $strUpperOp,
                'MinLatency(us)',
                $minLatency
            ));

            $maxLatency = $latency[$opKey]
                ? \max($latency[$opKey])
                : 0;
            $this->report(\sprintf(
                $template,
                $strUpperOp,
                'MaxLatency(us)',
                $maxLatency
            ));

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                '50thPercentile(us)',
                $this->percentile($latency[$opKey], 0.50)
            ));

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                '95thPercentile(us)',
                $this->percentile($latency[$opKey], 0.95)
            ));

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                '99thPercentile(us)',
                $this->percentile($latency[$opKey], 0.99)
            ));

            $this->report(\sprintf(
                $template,
                $strUpperOp,
                '99.9thPercentile(us)',
                $this->percentile($latency[$opKey], 0.999)
            ));
        }
    }

    public function __destruct()
    {
        if ($this->sapi !== 'cli') {
            echo $this->message;
        }
    }

    private function average(array $input)
    {
        $val = \count($input) > 0
            ? \array_sum($input) / \count($input)
            : 0;

        return $val * 1000;
    }

    private function standardDeviation(array $input)
    {
        $mean = $this->average($input);
        foreach ($input as &$val) {
            $val = \pow($val - $mean, 2);
        }
        return \sqrt($this->average($input)) * 1000;
    }

    private function percentile(array $input, $pct)
    {
        \sort($input);
        $i = \floor($pct * \count($input));

        $val = isset($input[$i]) ? $input[$i] : 0;

        return $val * 1000;
    }
}
