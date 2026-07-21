# GAX Showcase Conformance Testing

This directory contains the integration conformance test suite (`ShowcaseTest.php`) and generated client SDK for `gapic-showcase`.

## Prerequisites

- **Protobuf Compiler (`protoc`)**: Ensure `protoc` is installed and available in your `$PATH`.
- **Dev Dependencies**: Ensure dev dependencies are installed:
  ```sh
  composer install -d dev/
  ```

## Generating the Showcase Client

To generate or update the Showcase client SDK, message classes, and metadata using the PHP CLI tool:

```sh
# From the repository root, run the console command:
./dev/google-cloud showcase:generate
```

Options:
- `-o, --out-dir <dir>`: Output directory relative to repository root (defaults to `Gax`).
- `-p, --showcase-path <dir>`: Path to local `gapic-showcase` repository (defaults to installed vendor dependency).
- `-g, --generator-path <dir>`: Path to local `gapic-generator-php` (defaults to installed vendor dependency).
- `-a, --googleapis-path <dir>`: Path to `googleapis` repository (defaults to submodule in `gapic-generator-php`).

## Running Conformance Tests

1. Install and launch the matching `gapic-showcase` mock server in the background:
   ```sh
   # Option 1 (curl)
   curl -L https://github.com/googleapis/gapic-showcase/releases/download/v0.41.1/gapic-showcase-0.41.1-linux-amd64.tar.gz | tar -zx
   ./gapic-showcase run &

   # Option 2 (go install)
   go install github.com/googleapis/gapic-showcase/cmd/gapic-showcase@latest
   gapic-showcase run &
   ```

2. Run the PHPUnit conformance test suite:
   ```sh
   vendor/bin/phpunit -c Gax/phpunit-conformance.xml.dist
   # or from the Gax directory:
   cd Gax && vendor/bin/phpunit tests/Conformance/ShowcaseTest.php
   ```
