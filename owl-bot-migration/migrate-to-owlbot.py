#!/usr/bin/env python

from pathlib import Path
import re
import sys

from jinja2 import Environment
from jinja2 import FileSystemLoader


def scan_bazel_target(synth_py: Path) -> (str, str):
    with open(synth_py, "r") as f:
        for line in f.readlines():
            m = re.search('bazel_target=\'//(.*)/([^/]*):.*', line)
            if m:
                return (m.group(1), m.group(2))
    return ("", "")


def scan_for_owlbot(synth_py: Path) -> (str, bool, str):
    in_fix_year = False
    copyright_year = "2021"
    remainder = ""
    is_unique = False
    copy_partial_veneer = True
    with open(synth_py, "r") as f:
        for line in f.readlines():
            # detect copyright year
            m = re.search('Copyright (\d+) Google.*', line)
            if m:
                copyright_year = m.group(1)

            # detect if it's copying partial veneer
            m = re.search('except partial veneer classes', line)
            if m:
                copy_partial_veneer = False

            # detect copyright hack
            m = re.search('# fix year', line)
            if m:
                in_fix_year = True

            if is_unique and not in_fix_year:
                remainder += line

            # detect the end of original copy code
            m = re.search('proto/src/GPBMetadata', line)
            if m:
                is_unique = True

            # detect the end of copyright hack
            if in_fix_year:
                if line == "\n":
                    in_fix_year = False

    return (copyright_year, copy_partial_veneer, remainder)


def main(target_dir: str) -> None:
    """ Migrate from synth.py to owlbot.py at the given dir."""
    loader = FileSystemLoader("/tmpl")
    e = Environment(loader=loader)

    api_dir = Path(target_dir)
    synth_py = api_dir / "synth.py"


    if not synth_py.is_file():
        print("synth.py not found")
        sys.exit(1)


    (bazel_path, version_string) = scan_bazel_target(synth_py)

    yaml_tmpl = e.get_template("owlbot_yaml.tmpl")

    print("writing .OwlBot.yaml")

    with open(api_dir / ".OwlBot.yaml", "w") as f:
        f.write(yaml_tmpl.render(
            bazel_path=bazel_path,
            version_string=version_string,
            target_dir=target_dir
        ))

    (copyright_year, copy_partial_veneer, remainder) = scan_for_owlbot(synth_py)

    owlbot_py_tmpl = e.get_template("owlbot_py.tmpl")

    print("writing owlbot.py")

    with open(api_dir / "owlbot.py", "w") as f:
        f.write(owlbot_py_tmpl.render(
            copyright_year=copyright_year,
            target_dir=target_dir,
            copy_partial_veneer=copy_partial_veneer,
            remainder=remainder
        ))

    print("removing synth.py")
    unlink(synth_py)


if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("migrate-to-owlbot.py target_dir")
        sys.exit(1)
    main(sys.argv[1])
