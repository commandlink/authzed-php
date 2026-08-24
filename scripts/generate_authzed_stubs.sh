#!/usr/bin/env bash
#
# Regenerates the SpiceDB (Authzed) v1 gRPC client stubs in gen/.
#
# There is no official PHP client for SpiceDB — AuthZed maintains gRPC clients
# for Go, Node, Python, Ruby, Java and .NET only — so we generate our own from
# the published protos. The output is committed, so this only needs running when
# we want to move to a newer Authzed API.
#
# Requires the buf CLI:  brew install bufbuild/buf/buf
#
# Three steps, because `buf generate buf.build/authzed/api` on its own does not
# work for PHP:
#
#   1. Build a FileDescriptorSet from the published module.
#   2. Strip the proto2 validation dependencies the PHP generator refuses to
#      compile (see scripts/strip_authzed_descriptors.php).
#   3. Generate, then delete the output for protos whose PHP classes already
#      ship with google/protobuf and google/common-protos. Leaving them in
#      place would declare those classes twice.
#
set -euo pipefail

cd "$(dirname "$0")/.."

MODULE="${1:-buf.build/authzed/api}"
WORK="$(mktemp -d)"
trap 'rm -rf "$WORK"' EXIT

echo "==> Building descriptor set from ${MODULE}"
buf build "$MODULE" -o "$WORK/authzed.binpb" --as-file-descriptor-set

echo "==> Stripping proto2 validation dependencies"
php scripts/strip_authzed_descriptors.php "$WORK/authzed.binpb" "$WORK/authzed-php.binpb"

echo "==> Generating PHP stubs into gen/"
rm -rf gen
buf generate "$WORK/authzed-php.binpb" --template proto/buf.gen.yaml

echo "==> Removing stubs provided by Composer packages"
# google/protobuf ships Google\Protobuf\* and GPBMetadata\Google\Protobuf\*.
# google/common-protos ships Google\Api\*, Google\Rpc\* and their metadata.
rm -rf gen/Google gen/GPBMetadata/Google

echo "==> Recording the source module"
# Without this a regeneration silently tracks whatever "latest" was that day.
# `buf build` resolves the module, so ask it what it actually used.
buf mod info "$MODULE" > gen/.authzed-module 2>/dev/null \
  || echo "$MODULE (unresolved; buf mod info unavailable)" > gen/.authzed-module

echo "==> Verifying the generated stubs load"
php scripts/verify_authzed_stubs.php

echo "==> Done. Commit the contents of gen/, including .authzed-module."
