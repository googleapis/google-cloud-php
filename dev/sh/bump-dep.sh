#!/bin/bash

set -ev

# This script expects to be run from the google-cloud-php root.
# It finds all composer.json files and updates the google/gax
# version to the specified command line argument.
#
# Usage (to update gax version to e.g. 0.1.2):
# $ ./dev/sh/bump-dep.sh 'google/gax' 0.1.2

dep=$(echo $1 | sed 's/\//\\\//g')

find . -maxdepth 2 -name composer.json \
     -not -path "./vendor/*" \
     -exec sed -i "s/$dep[\"']: [\"']\^[0-9]\+\.[0-9]\+\(\.[0-9]\+\)\?[\"']/$dep\": \"\^$2\"/" "{}" \;
