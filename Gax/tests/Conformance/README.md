# GAX Showcase Conformance Testing

This directory contains the integration conformance test suite (`ShowcaseTest.php`) and generated client SDK for `gapic-showcase`.

## Generating the Showcase Client

To generate or update the Showcase client SDK, message classes, and metadata using the PHP CLI tool:

```sh
# From the repository root, run the console command:
./dev/google-cloud gax:generate-showcase --showcase-path /path/to/gapic-showcase
```

Options:
- `-p, --showcase-path <dir>`: Path to local `gapic-showcase` repository (**required**).
- `-g, --generator-path <dir>`: Path to local `gapic-generator-php` (optional; defaults to installed dependency in `dev/vendor`).
- `-a, --googleapis-path <dir>`: Path to `googleapis` repository (optional; defaults to submodule in `gapic-generator-php`).

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
