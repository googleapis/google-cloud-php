# BigQuery Benchmark
This directory contains benchmarks for BigQuery client.

## Usage
From the `src/BigQuery` directory, set up by running `composer install`.

`php Benchmark/Benchmark.php Benchmark/queries.json`

BigQuery service caches requests so the benchmark should be run
at least twice, disregarding the first result.
