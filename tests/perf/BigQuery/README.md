# BigQuery Benchmark
This directory contains benchmarks for BigQuery client.

## Usage
From the `google-cloud-php` directory, set up by running `composer install`.

`php tests/perf/BigQuery/Benchmark.php tests/perf/BigQuery/queries.json`

BigQuery service caches requests so the benchmark should be run
at least twice, disregarding the first result.
