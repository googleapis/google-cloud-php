#!/bin/bash
# Copyright 2025 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#      http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

set -eo pipefail

## Get the directory of the build script
proxyDir=$(realpath $(dirname "${BASH_SOURCE[0]}"))
projectDir=$(realpath $proxyDir/../../../..)

# Install composer dependencies in the "proxy" directory
composer update -d $proxyDir

set +e

# declare -a configs=("default" "enable_all")
declare -a configs=("default") # PHP only supports "default" feature flags for now
for config in "${configs[@]}"
do
  # Start the proxy in a separate process
  rr serve -w $proxyDir &
  proxyPID=$!

  pushd .
  cd $projectDir/cloud-bigtable-clients-test/tests

  skipTests=$(sed -n 'H;${x;s/\n/\\|/g;s/^\\|//;p;};d' < $proxyDir/known_failures.txt)
  eval "go test -v -proxy_addr=:9999 -skip ${skipTests}"
  returnCode=$?
  popd

  # Stop the proxy
  kill ${proxyPID}

  if [[ ${returnCode} -gt 0 ]]
  then
    echo "Conformance test failed for config: ${config}"
    RETURN_CODE=${returnCode}
  else
    echo "Conformance test passed for config: ${config}"
  fi
done

exit ${RETURN_CODE}
