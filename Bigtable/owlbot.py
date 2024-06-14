# Copyright 2018 Google LLC
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
import subprocess

import synthtool as s
from synthtool.languages import php
from synthtool import _tracked_paths

logging.basicConfig(level=logging.DEBUG)

src = Path(f"../{php.STAGING_DIR}/Bigtable").resolve()
dest = Path().resolve()

# For preserving the copyright year, we use php._merge function
preserve_copyright_year = php._merge

# Added so that we can pass copy_excludes in the owlbot_main() call
_tracked_paths.add(src)

# Excluding the partial veneer files.
php.owlbot_main(
    src=src,
    dest=dest,
    copy_excludes=[
        src / "**/[A-Z]*_*.php",
    ]
)

# First copy the Bigtable Admin
admin_library = Path(f"../{php.STAGING_DIR}/Bigtable/v2/Admin").resolve()

# copy gapic src and tests
s.move(admin_library / f'src', 'src/Admin', merge=preserve_copyright_year)
s.move(admin_library / f'tests/Unit', 'tests/Unit/Admin', merge=preserve_copyright_year)

# copy proto and metadata files
s.move(admin_library / f'proto/src/Google/Cloud/Bigtable', f'src/', merge=preserve_copyright_year)
s.move(admin_library / f'proto/src/GPBMetadata/Google/Bigtable', f'metadata/', merge=preserve_copyright_year)

