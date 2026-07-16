# GAX Showcase Conformance Testing

This directory contains the integration conformance test suite (`ShowcaseTest.php`) and generated client SDK for `gapic-showcase`.

## Generating the Showcase Client

To generate or update the Showcase client SDK, message classes, metadata, and server binary:

```sh
# From the Gax directory, run via Composer:
GAPIC_GENERATOR_PHP_PATH=/path/to/gapic-generator-php composer generate-showcase

# To specify a custom version tag:
GAPIC_GENERATOR_PHP_PATH=/path/to/gapic-generator-php composer generate-showcase -- --version v0.41.1
```

Or run the script directly:
```sh
./generate-showcase.sh \
  --generator-path /path/to/gapic-generator-php \
  --version v0.41.1
```

## Running Conformance Tests

1. Launch the matching Showcase mock server in the background or in a separate terminal:
   ```sh
   ./tests/Conformance/bin/gapic-showcase run
   ```

2. Run the PHPUnit conformance test suite:
   ```sh
   vendor/bin/phpunit tests/Conformance/ShowcaseTest.php
   ```
