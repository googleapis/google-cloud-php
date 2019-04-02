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
        return new self(php_sapi_name());
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

    public function average(array $input)
    {
        return count($input) > 0
            ? array_sum($input) / count($input)
            : 0;
    }

    public function standardDeviation(array $input)
    {
        $mean = $this->average($input);
        foreach ($input as &$val) {
            $val = pow($val - $mean, 2);
        }
        return sqrt($this->average($input));
    }

    public function percentile(array $input, $pct)
    {
        sort($input);
        $i = floor($pct * count($input));
        return isset($input[$i]) ? $input[$i] : 0;
    }

    public function aggregateMetrics(array $latency, $duration)
    {
        $overallOpCount = 0;
        $oppCounts = [];

        foreach ($latency as $opKey => $arrDurations) {
            $oppCounts[$opKey] = count($arrDurations);
            $overallOpCount += $oppCounts[$opKey];
        }

        $r = $overallOpCount / $duration;
        $this->report("[OVERALL] Throughput (Ops/sec), $r \n");

        foreach ($oppCounts as $opKey => $intOpCounts) {
            $strUpperOp = strtoupper($opKey);
            $this->report("[$strUpperOp], Operations: $intOpCounts. \n");

            $r = $this->average($latency[$opKey])*1000;
            $this->report("[$strUpperOp], AverageLatency(us) $r \n");

            $r = $this->standardDeviation($latency[$opKey])*1000;
            $this->report("[$strUpperOp], LatencyVariance(us) $r \n");

            $r = $latency[$opKey]
                ? min($latency[$opKey])*1000
                : 0;
            $this->report("[$strUpperOp], MinLatency(us) $r \n");

            $r = $latency[$opKey]
                ? max($latency[$opKey])*1000
                : 0;
            $this->report("[$strUpperOp], MaxLatency(us) $r \n");

            $r = $this->percentile($latency[$opKey], 0.50)*1000;
            $this->report("[$strUpperOp], 50thPercentile(us) $r \n");

            $r = $this->percentile($latency[$opKey], 0.95)*1000;
            $this->report("[$strUpperOp], 95thPercentile(us) $r \n");

            $r = $this->percentile($latency[$opKey], 0.99)*1000;
            $this->report("[$strUpperOp], 99thPercentile(us) $r \n");

            $r = $this->percentile($latency[$opKey], 0.999)*1000;
            $this->report("[$strUpperOp], 99.9thPercentile(us) $r \n");
        }
    }

    public function __destruct()
    {
        if ($this->sapi !== 'cli') {
            echo $this->message;
        }
    }
}
