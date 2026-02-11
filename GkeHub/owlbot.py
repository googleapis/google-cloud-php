# Copyright 2023 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

"""This script is used to synthesize generated parts of this library."""

import logging
from pathlib import Path
import shutil
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/GkeHub").resolve()
dest = Path().resolve()

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

# Handle non-standard version numbers in namespace - the version should come
# before the namespace, but in this case, the protos are misconfigured.
# (they should be "V1/MultiClusterIngress" instead of "MultiClusterIngress/V1")
proto_dir = src / "v1/proto/src/Google/Cloud/GkeHub"
s.move([proto_dir / "ConfigManagement"], dest / "src/ConfigManagement", merge=php._merge)
s.move([proto_dir / "MultiClusterIngress"], dest / "src/MultiClusterIngress", merge=php._merge)
s.move([proto_dir / "RbacRoleBindingActuation"], dest / "src/RbacRoleBindingActuation", merge=php._merge)
shutil.rmtree(proto_dir / "ConfigManagement")
shutil.rmtree(proto_dir / "MultiClusterIngress")
shutil.rmtree(proto_dir / "RbacRoleBindingActuation")

php.owlbot_main(src=src, dest=dest)

# remove class_alias code
s.replace(
    "src/V*/**/*.php",
    r"^// Adding a class alias for backwards compatibility with the previous class name.$"
    + "\n"
    + r"^class_alias\(.*\);$"
    + "\n",
    '')

# format generated clients
subprocess.run([
    'npm',
    'exec',
    '--yes',
    '--package=@prettier/plugin-php@^0.19',
    '--',
    'prettier',
    '**/Client/*',
    '--write',
    '--parser=php',
    '--single-quote',
    '--print-width=120'])
