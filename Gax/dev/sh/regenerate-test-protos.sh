#!/bin/bash

# Run this script whenever changes are made to mocks.proto to regenerate the
# PHP protobuf message classes.
#
# This script expected to be invoked from the gax-php root using:
# $ composer regenerate-test-protos

echo ${pwd}
cd src
protoc --php_out . ./Testing/mocks.proto
cp -r ./GPBMetadata/* ../metadata/
cp -r ./Google/ApiCore/* ./
rm -r ./GPBMetadata
rm -r ./Google
