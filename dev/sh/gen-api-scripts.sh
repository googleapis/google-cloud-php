#!/bin/bash

SCRIPTS=$(find ./dev/sh/apis/*)

for f in $SCRIPTS; do
  g=$f
  g="${g/-/_}"
  g=${g:14}
  cat << EOF > $f
#!/bin/bash

source ./dev/sh/gapic-generation-functions.sh

setup_environment

regenerate_$g

post_regenerate
EOF
done
