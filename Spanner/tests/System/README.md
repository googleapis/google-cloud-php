# Google Cloud Spanner System Tests

## Run the system tests

### Set the environment variables

```bash
# These environment variables are required
GOOGLE_CLOUD_PHP_TESTS_KEY_PATH="/path/to/service-account.json"
GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH="<SAME AS ABOVE>"
GOOGLE_CLOUD_PROJECT="<YOUR_PROJECT_ID>"

# These environment variables are optional, and will speed up running the tests locally
GOOGLE_CLOUD_SPANNER_TEST_DATABASE=test-database
GOOGLE_CLOUD_SPANNER_TEST_BACKUP_DATABASE_1=test-backup-database1
GOOGLE_CLOUD_SPANNER_TEST_BACKUP_DATABASE_2=test-backup-database2
```

### Run PHPUnit

```
vendor/bin/phpunit -c phpunit-system.xml.dist  --stop-on-failure tests/System/BatchTest.php
```

## Run the emulator

Some tests ONLY run against the emulator. To run those, you'll need to run the emulator locally.