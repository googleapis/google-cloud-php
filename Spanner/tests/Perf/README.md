# Cloud Spanner YCSB

To execute spanner performance tests, make sure Composer dependencies are installed at either a component or library level.

* Configure a table with the schema provided [here](https://github.com/brianfrankcooper/YCSB/tree/master/cloudspanner).
* Configure Application Default Credentials.
* Call the script from the command line:

```
php ycsb.php --operationcount=50 \
             --instance=<instance> \
             --database=<database> \
             --table=<table> \
             --workload=/path/to/Spanner/tests/Perf/pkb/workloada
```

Refer to the [YCSB documentation](https://github.com/brianfrankcooper/YCSB/tree/master/cloudspanner) for more detail, such as loading test data.

Threading is not supported. Execute the PHP script multiple times in parallel.
