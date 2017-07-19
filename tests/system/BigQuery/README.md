## Managing Resources in BigQuery System Tests

Whenever possible (i.e. when your test does not mutate datasets), you should use
the default bucket available at `BigQueryTestCase::$bucket`. If you must create a
dataset, use `BigQueryTestCase::createDataset()` in order to correctly configure
the deletion queue.

Because datasets cannot be deleted unless they are empty, it is sometimes
difficult to ensure that deletion is queued in the correct order. Due to this,
tables should NOT be added to the deletion queue. Instead, they should be
created inside a dataset which was created using
`BigQueryTestCase::createDataset()`.

When the deletion queue is processed, all datasets created using the
`BigQueryTestCase::createDataset()` method will be deleted with the
`deleteContents` flag set to override the deletion protections in the service.
