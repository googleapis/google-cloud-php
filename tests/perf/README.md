## Performance Tests

Some services contained in Google Cloud PHP provide a performance test, to allow
Google engineers and others to measure the performance of a client library.

Like other test suites in Google Cloud PHP, performance tests are implemented
using PHPUnit. Due to the memory-intensive nature of many of these tests, however,
and the time required to run all tests, it is recommended that you use the test
group feature to run only the tests required at a given time.

Running the tests is easy, once you have cloned the repository and run
`composer install` to install all required dependencies.

From the repository root, run the following command:

```sh
$ vendor/bin/phpunit -c phpunit-perf.xml.dist --group=<group-name>
```

The group name can be identified by opening a test file (i.e.
`tests/perf/BigQueryTest.php`), and looking for the `@group` annotation found
immediately before the class declaration:

```php
/**
 * @group bigquery
 */
class BigQueryTest extends TestCase
```
