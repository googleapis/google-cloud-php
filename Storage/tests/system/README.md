## Managing Resources in Storage System Tests

Whenever possible (i.e. when your test does not mutate buckets), you should use
the default bucket available at `StorageTestCase::$bucket`. If you must create a
bucket, use `StorageTestCase::createBucket()` in order to correctly configure
the deletion queue.

Because buckets cannot be deleted unless they are empty, it is sometimes
difficult to ensure that deletion is queued in the correct order. Due to this,
objects should NOT be added to the deletion queue. Instead, they should be
created inside a bucket which was created using
`StorageTestCase::createBucket()`.

When the deletion queue is processed, all buckets created using the
`StorageTestCase::createBucket()` method will be emptied of all objects residing
in them prior to the deletion of the bucket itself.
