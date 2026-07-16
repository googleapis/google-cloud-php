#!/bin/bash
set -e

# Determine directory relative to script location
GAX_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

GAX_CONFORMANCE_DIR="$GAX_DIR/tests/Conformance"
TMP_SHOWCASE_DIR="$GAX_CONFORMANCE_DIR/tmp_showcase"
TMP_OUTPUT="$GAX_CONFORMANCE_DIR/tmp_out"
DESC_FILE="$GAX_CONFORMANCE_DIR/desc.pb"

# Command-Line Options
CUSTOM_GENERATOR_PATH=""
CUSTOM_GOOGLEAPIS_PATH=""
CUSTOM_SHOWCASE_PATH=""
CUSTOM_VERSION=""

while [[ $# -gt 0 ]]; do
  case $1 in
    -g|--generator-path)
      CUSTOM_GENERATOR_PATH="$2"
      shift 2
      ;;
    -a|--googleapis-path)
      CUSTOM_GOOGLEAPIS_PATH="$2"
      shift 2
      ;;
    -p|--showcase-path|--path)
      CUSTOM_SHOWCASE_PATH="$2"
      shift 2
      ;;
    -v|--version)
      CUSTOM_VERSION="$2"
      shift 2
      ;;
    -h|--help)
      echo "Usage: ./generate-showcase.sh [options]"
      echo ""
      echo "Options:"
      echo "  -g, --generator-path <dir>   Path to gapic-generator-php repository (or set GAPIC_GENERATOR_PHP_PATH)"
      echo "  -a, --googleapis-path <dir>  Path to googleapis repository (or set GOOGLEAPIS_PATH)"
      echo "  -p, --showcase-path <dir>    Path to local gapic-showcase repository (or set SHOWCASE_PATH)"
      echo "  -v, --version <tag>          Specify a custom gapic-showcase release tag (e.g. v0.41.1)"
      echo "  -h, --help                   Show this help message"
      exit 0
      ;;
    *)
      echo "Unknown option: $1"
      exit 1
      ;;
  esac
done

# Resolve configuration from CLI options or environment variables
GAPIC_GENERATOR_PHP="${CUSTOM_GENERATOR_PATH:-$GAPIC_GENERATOR_PHP_PATH}"
GOOGLEAPIS_DIR="${CUSTOM_GOOGLEAPIS_PATH:-$GOOGLEAPIS_PATH}"
SPECIFIED_SHOWCASE_PATH="${CUSTOM_SHOWCASE_PATH:-$SHOWCASE_PATH}"
TARGET_VERSION="${CUSTOM_VERSION:-$SHOWCASE_VERSION}"

# Validate required dependency paths
if [ -z "$GAPIC_GENERATOR_PHP" ] || [ ! -f "$GAPIC_GENERATOR_PHP/vendor/autoload.php" ]; then
    echo "Error: gapic-generator-php not found."
    echo "Please specify the path using --generator-path <dir> or set the GAPIC_GENERATOR_PHP_PATH environment variable."
    exit 1
fi

# Auto-fetch googleapis from GitHub if not specified
TMP_GOOGLEAPIS_DIR="$GAX_CONFORMANCE_DIR/tmp_googleapis"
if [ -z "$GOOGLEAPIS_DIR" ] || [ ! -d "$GOOGLEAPIS_DIR/google/cloud" ]; then
    echo "Fetching googleapis definitions from GitHub..."
    rm -rf "$TMP_GOOGLEAPIS_DIR"
    mkdir -p "$TMP_GOOGLEAPIS_DIR"
    git clone --depth 1 https://github.com/googleapis/googleapis.git "$TMP_GOOGLEAPIS_DIR" >/dev/null 2>&1 || true
    if [ -d "$TMP_GOOGLEAPIS_DIR/google/cloud" ]; then
        GOOGLEAPIS_DIR="$TMP_GOOGLEAPIS_DIR"
    fi
fi

if [ -z "$GOOGLEAPIS_DIR" ] || [ ! -d "$GOOGLEAPIS_DIR/google/cloud" ]; then
    echo "Error: googleapis directory not found."
    echo "Please specify the path using --googleapis-path <dir> or set the GOOGLEAPIS_PATH environment variable."
    exit 1
fi

echo "1. Resolving gapic-showcase schemas and binary..."

SHOWCASE_DIR=""
RESOLVED_TAG=""

if [ -n "$SPECIFIED_SHOWCASE_PATH" ] && [ -d "$SPECIFIED_SHOWCASE_PATH/schema/google/showcase/v1beta1" ]; then
    SHOWCASE_DIR="$SPECIFIED_SHOWCASE_PATH"
    echo "Using specified local gapic-showcase path: $SHOWCASE_DIR"
else
    if [ -n "$TARGET_VERSION" ]; then
        RESOLVED_TAG="$TARGET_VERSION"
    else
        echo "Querying GitHub for latest gapic-showcase release tag..."
        RESOLVED_TAG=$(curl -s https://api.github.com/repos/googleapis/gapic-showcase/releases/latest | grep '"tag_name":' | sed -E 's/.*"([^"]+)".*/\1/' || true)
    fi

    if [ -n "$RESOLVED_TAG" ]; then
        echo "Fetching gapic-showcase schema for tag: $RESOLVED_TAG..."
        rm -rf "$TMP_SHOWCASE_DIR"
        mkdir -p "$TMP_SHOWCASE_DIR"
        git clone --depth 1 --branch "$RESOLVED_TAG" https://github.com/googleapis/gapic-showcase.git "$TMP_SHOWCASE_DIR" >/dev/null 2>&1 || true

        if [ -d "$TMP_SHOWCASE_DIR/schema/google/showcase/v1beta1" ]; then
            SHOWCASE_DIR="$TMP_SHOWCASE_DIR"
        fi
    fi
fi

if [ -z "$SHOWCASE_DIR" ]; then
    echo "Error: Unable to resolve gapic-showcase schemas."
    echo "Please specify a local path using --showcase-path <dir> (or SHOWCASE_PATH env var) or ensure internet access to fetch from GitHub."
    exit 1
fi

SCHEMA_DIR="$SHOWCASE_DIR/schema/google/showcase/v1beta1"

# Download matching pre-built gapic-showcase binary executable into tests/Conformance/bin
if [ -n "$RESOLVED_TAG" ]; then
    echo "Downloading matching gapic-showcase server binary ($RESOLVED_TAG)..."
    OS_TYPE="$(uname -s | tr '[:upper:]' '[:lower:]')"
    ARCH_TYPE="$(uname -m)"

    case "$OS_TYPE" in
        linux*)  SYS_OS="linux" ;;
        darwin*) SYS_OS="darwin" ;;
        *)       SYS_OS="linux" ;;
    esac

    case "$ARCH_TYPE" in
        x86_64|amd64) SYS_ARCH="amd64" ;;
        aarch64|arm64) SYS_ARCH="arm64" ;;
        *)            SYS_ARCH="amd64" ;;
    esac

    VERSION_NUM="${RESOLVED_TAG#v}"
    BINARY_TAR="gapic-showcase-${VERSION_NUM}-${SYS_OS}-${SYS_ARCH}.tar.gz"
    BINARY_URL="https://github.com/googleapis/gapic-showcase/releases/download/${RESOLVED_TAG}/${BINARY_TAR}"

    BIN_DIR="$GAX_CONFORMANCE_DIR/bin"
    mkdir -p "$BIN_DIR"

    if curl -sL "$BINARY_URL" -o "$BIN_DIR/$BINARY_TAR" 2>/dev/null && [ -s "$BIN_DIR/$BINARY_TAR" ]; then
        tar -xzf "$BIN_DIR/$BINARY_TAR" -C "$BIN_DIR" gapic-showcase 2>/dev/null || tar -xzf "$BIN_DIR/$BINARY_TAR" -C "$BIN_DIR" 2>/dev/null
        chmod +x "$BIN_DIR/gapic-showcase" 2>/dev/null || true
        rm -f "$BIN_DIR/$BINARY_TAR"
        echo "Saved matching server binary to: $BIN_DIR/gapic-showcase"
    else
        echo "Note: Could not download pre-built binary for $BINARY_TAR. Existing server binary will be used."
        rm -f "$BIN_DIR/$BINARY_TAR"
    fi
fi

echo "2. Cleaning up existing temporary outputs..."
rm -rf "$TMP_OUTPUT" "$DESC_FILE"
mkdir -p "$TMP_OUTPUT/src"

echo "3. Compiling proto descriptor set (desc.pb)..."
protoc \
  --include_imports \
  --include_source_info \
  -I "$SHOWCASE_DIR/schema" \
  -I "$GOOGLEAPIS_DIR" \
  --descriptor_set_out="$DESC_FILE" \
  "$SCHEMA_DIR/echo.proto" \
  "$SCHEMA_DIR/identity.proto" \
  "$SCHEMA_DIR/compliance.proto" \
  "$SCHEMA_DIR/sequence.proto" \
  "$SCHEMA_DIR/testing.proto" \
  "$GOOGLEAPIS_DIR/google/cloud/common_resources.proto"

echo "4. Generating GAPIC PHP client for GAX (gRPC + REST, MIGRATING mode)..."
php -r "
require '$GAPIC_GENERATOR_PHP/vendor/autoload.php';
use Google\Generator\CodeGenerator;
use Google\Generator\Utils\MigrationMode;

\$descBytes = file_get_contents('$DESC_FILE');
\$grpcConfig = file_get_contents('$SCHEMA_DIR/showcase_grpc_service_config.json');

\$files = CodeGenerator::generateFromDescriptor(
    \$descBytes,
    'google.showcase.v1beta1',
    'grpc+rest',
    false,
    \$grpcConfig,
    null,
    null,
    false,
    -1,
    false,
    MigrationMode::MIGRATING
);

foreach (\$files as [\$relPath, \$content]) {
    \$fullPath = '$TMP_OUTPUT/' . \$relPath;
    @mkdir(dirname(\$fullPath), 0777, true);
    file_put_contents(\$fullPath, \$content);
}
"

echo "5. Generating Protobuf message classes..."
ALL_PROTOS=("$SCHEMA_DIR"/*.proto)
protoc \
  -I "$SHOWCASE_DIR/schema" \
  -I "$GOOGLEAPIS_DIR" \
  --php_out="$TMP_OUTPUT/src" \
  "${ALL_PROTOS[@]}"

echo "6. Organizing output into GAX Conformance directory..."
rm -rf "$GAX_CONFORMANCE_DIR/src/V1beta1" "$GAX_CONFORMANCE_DIR/metadata"
mkdir -p "$GAX_CONFORMANCE_DIR/src/V1beta1/resources"

# Copy generated GAPIC Client SDK files (Client/, Gapic/, facade classes)
if [ -d "$TMP_OUTPUT/src/V1beta1" ]; then
  cp -r "$TMP_OUTPUT/src/V1beta1"/* "$GAX_CONFORMANCE_DIR/src/V1beta1/"
fi

# Copy Protobuf Message classes (EchoRequest.php, Session.php, etc.)
if [ -d "$TMP_OUTPUT/src/Google/Showcase/V1beta1" ]; then
  cp -r "$TMP_OUTPUT/src/Google/Showcase/V1beta1"/* "$GAX_CONFORMANCE_DIR/src/V1beta1/"
fi

# Copy REST client config resources
if [ -d "$TMP_OUTPUT/resources" ]; then
  cp -r "$TMP_OUTPUT/resources"/* "$GAX_CONFORMANCE_DIR/src/V1beta1/resources/"
fi

# Copy metadata preserving directory case (V1Beta1)
rm -rf "$GAX_CONFORMANCE_DIR/metadata"
mkdir -p "$GAX_CONFORMANCE_DIR/metadata"
if [ -d "$TMP_OUTPUT/src/GPBMetadata/Google/Showcase" ]; then
  cp -r "$TMP_OUTPUT/src/GPBMetadata/Google/Showcase"/* "$GAX_CONFORMANCE_DIR/metadata/"
fi

echo "7. Cleaning up temporary files..."
rm -rf "$TMP_OUTPUT" "$DESC_FILE" "$TMP_SHOWCASE_DIR" "$TMP_GOOGLEAPIS_DIR"

echo "✅ Showcase Client generation complete! Output saved in: $GAX_CONFORMANCE_DIR"
if [ -f "$GAX_CONFORMANCE_DIR/bin/gapic-showcase" ]; then
  echo "💡 To run the matching Showcase server binary: $GAX_CONFORMANCE_DIR/bin/gapic-showcase run"
fi
