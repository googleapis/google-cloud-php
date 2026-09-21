# Google Cloud Spanner System Tests

## Run the system tests

### Set the environment variables

```bash
# These environment variables are required
GOOGLE_CLOUD_PHP_TESTS_KEY_PATH="/path/to/service-account.json"
GOOGLE_CLOUD_PHP_WHITELIST_TESTS_KEY_PATH="<SAME AS ABOVE>"
GOOGLE_CLOUD_PROJECT="<YOUR_PROJECT_ID>"

# This environment variable is required for UniverseDomainTest. If absent, UniverseDomainTest will be skipped.
GOOGLE_CLOUD_PHP_TESTS_UNIVERSE_DOMAIN_KEY_PATH="<SAME AS ABOVE>"

# These environment variables are optional, and will speed up running the tests locally
GOOGLE_CLOUD_SPANNER_TEST_DATABASE=test-database
GOOGLE_CLOUD_SPANNER_TEST_PG_DATABASE=test-pg-database
GOOGLE_CLOUD_SPANNER_TEST_BACKUP_DATABASE=test-backup-database
```

### For sequential execution: run PHPUnit

```
vendor/bin/phpunit -c phpunit-system.xml.dist
```

### For parallel execution: run paratest

```
vendor/bin/paratest -p <NUMBER_OF_PROCESSES, 4 recommended> -c phpunit-system.xml.dist  
```

## Run the emulator

Emulator can only run some tests and skip about 1/3 of the tests. You'll need to run the emulator locally.