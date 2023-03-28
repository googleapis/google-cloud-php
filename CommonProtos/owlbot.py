# Copyright 2022 Google LLC
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
from pathlib import PosixPath
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

audit_src = Path(f"../{php.STAGING_DIR}/CommonProtos/audit-protos").resolve()
devtools_src = Path(f"../{php.STAGING_DIR}/CommonProtos/devtools-protos").resolve()
common_src = Path(f"../{php.STAGING_DIR}/CommonProtos/common-protos").resolve()
dest = Path().resolve()

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(audit_src)
_tracked_paths.add(devtools_src)
_tracked_paths.add(common_src)

# use owlbot_copy_version instead of owlbot_main and set "version_string"
# manually because some common protos do not have a version
php.owlbot_copy_version(
    src=audit_src,
    dest=dest,
    copy_excludes=[
        audit_src / "**/[A-Z]*_*.php"
    ],
    version_string="audit",
)
php.owlbot_copy_version(
    src=devtools_src,
    dest=dest,
    copy_excludes=[
        devtools_src / "**/[A-Z]*_*.php"
    ],
    version_string="devtools",
)
php.owlbot_copy_version(
    src=common_src,
    dest=dest,
    copy_excludes=[
        common_src / "**/[A-Z]*_*.php"
    ],
    version_string="common",
)

# remove class_alias code (but keep the existing class aliases)
sources = list(Path(".").glob("src/**/*.php"))
sources.remove(PosixPath("src/Audit/ServiceAccountDelegationInfo/FirstPartyPrincipal.php"))
sources.remove(PosixPath("src/Audit/ServiceAccountDelegationInfo/ThirdPartyPrincipal.php"))
sources.remove(PosixPath("src/DevTools/Source/V1/AliasContext/Kind.php"))
s.replace(
    sources,
    r"^// Adding a class alias for backwards compatibility with the previous class name.$"
    + "\n"
    + r"^class_alias\(.*\);$"
    + "\n",
    '')

