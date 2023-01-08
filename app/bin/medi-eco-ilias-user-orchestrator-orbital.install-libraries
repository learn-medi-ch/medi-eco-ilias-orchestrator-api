#!/usr/bin/env sh

set -e

libs="`dirname "$0"`/../libs"

installLibrary() {
    (mkdir -p "$libs/$1" && cd "$libs/$1" && wget -O - "$2" | tar -xz --strip-components=1)
}

installLibrary simple-xlsx https://github.com/shuchkin/simplexlsx/archive/refs/tags/1.0.18.tar.gz