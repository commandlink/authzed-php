<?php

/**
 * Rewrites a FileDescriptorSet so the protobuf PHP generator can compile it.
 *
 * The SpiceDB (Authzed) protos annotate their fields with protoc-gen-validate
 * and protovalidate rules. Both of those option packages are defined in proto2
 * files, and the protobuf PHP generator refuses proto2 outright:
 *
 *     Can't generate PHP code for closed enum buf.validate.Ignore.
 *
 * The rules are client-side validation hints only — SpiceDB validates every
 * request server-side regardless — and no Authzed *message field* is typed from
 * those files, so dropping them costs us nothing at runtime.
 *
 * This script drops those files from the set and removes them from every
 * remaining file's dependency list, so the generator never emits an initOnce()
 * call for a class that cannot exist. Files listed in KEEP_AS_IMPORT stay in the
 * set (their descriptors are needed) but their PHP classes ship with Composer
 * packages, so generate_authzed_stubs.sh deletes the regenerated copies.
 *
 * Usage: php scripts/strip_authzed_descriptors.php <in.binpb> <out.binpb>
 *
 * @see scripts/generate_authzed_stubs.sh
 */

require __DIR__.'/../vendor/autoload.php';

use Google\Protobuf\Internal\FileDescriptorSet;

/**
 * Proto files removed from the descriptor set entirely.
 *
 * Prefix match. Everything here is option-only: it contributes annotations to
 * the Authzed protos, never a field type. Note that dropping descriptor.proto
 * forces us to drop everything that extends it too — the option packages above
 * all declare `extend google.protobuf.MethodOptions` and friends, which stop
 * resolving the moment descriptor.proto leaves the set.
 */
const DROP_PREFIXES = [
    'buf/validate/',                // protovalidate — proto2, ungeneratable
    'validate/',                    // protoc-gen-validate — proto2, ungeneratable
    'google/protobuf/descriptor.',  // proto2, ungeneratable
    'protoc-gen-openapiv2/',        // OpenAPI doc annotations; extends descriptor.proto
    'google/api/',                  // HTTP gateway annotations; extends descriptor.proto
];

if ($argc !== 3) {
    fwrite(STDERR, "usage: php {$argv[0]} <in.binpb> <out.binpb>\n");
    exit(1);
}

[, $inPath, $outPath] = $argv;

$set = new FileDescriptorSet();
$set->mergeFromString(file_get_contents($inPath));

$dropped = [];
foreach ($set->getFile() as $file) {
    foreach (DROP_PREFIXES as $prefix) {
        if (str_starts_with($file->getName(), $prefix)) {
            $dropped[$file->getName()] = true;
            break;
        }
    }
}

$kept = [];
foreach ($set->getFile() as $file) {
    if (isset($dropped[$file->getName()])) {
        continue;
    }

    // Rebuild the dependency list without the dropped files. public_dependency
    // and weak_dependency hold indexes into it, so they have to be remapped.
    $dependencies = [];
    $newIndexes = [];

    foreach ($file->getDependency() as $index => $dependency) {
        if (isset($dropped[$dependency])) {
            $newIndexes[$index] = null;

            continue;
        }

        $newIndexes[$index] = count($dependencies);
        $dependencies[] = $dependency;
    }

    $file->setDependency($dependencies);

    foreach (['PublicDependency', 'WeakDependency'] as $kind) {
        $remapped = [];

        foreach ($file->{"get$kind"}() as $index) {
            if (($newIndexes[$index] ?? null) !== null) {
                $remapped[] = $newIndexes[$index];
            }
        }

        $file->{"set$kind"}($remapped);
    }

    $kept[] = $file;
}

$set->setFile($kept);
file_put_contents($outPath, $set->serializeToString());

fwrite(STDERR, sprintf(
    "dropped %d file(s): %s\nkept %d file(s)\n",
    count($dropped),
    implode(', ', array_keys($dropped)),
    count($kept),
));
