<?php

/**
 * Smoke-checks the generated SpiceDB stubs in gen/.
 *
 * A descriptor pool problem in generated protobuf code only surfaces the first
 * time a message class is touched, which in a web request means a fatal error
 * deep inside an authorization check. This walks everything the consuming
 * RebacService implementations depend on, so generate_authzed_stubs.sh fails
 * loudly at generation time instead.
 *
 * Keep this in step with those clients: if either starts using a new message or
 * enum value, add it here so a regeneration that drops it is caught by CI rather
 * than in production.
 *
 * Usage: php scripts/verify_authzed_stubs.php
 */

require __DIR__.'/../vendor/autoload.php';

use Authzed\Api\V1\CheckBulkPermissionsRequest;
use Authzed\Api\V1\CheckBulkPermissionsRequestItem;
use Authzed\Api\V1\CheckBulkPermissionsResponse;
use Authzed\Api\V1\CheckPermissionRequest;
use Authzed\Api\V1\CheckPermissionResponse;
use Authzed\Api\V1\Consistency;
use Authzed\Api\V1\LookupPermissionship;
use Authzed\Api\V1\LookupResourcesRequest;
use Authzed\Api\V1\LookupResourcesResponse;
use Authzed\Api\V1\LookupSubjectsRequest;
use Authzed\Api\V1\LookupSubjectsResponse;
use Authzed\Api\V1\ObjectReference;
use Authzed\Api\V1\PartialCaveatInfo;
use Authzed\Api\V1\PermissionsServiceClient;
use Authzed\Api\V1\ReadSchemaRequest;
use Authzed\Api\V1\ReadSchemaResponse;
use Authzed\Api\V1\ResolvedSubject;
use Authzed\Api\V1\SchemaServiceClient;
use Authzed\Api\V1\SubjectReference;

$failures = [];

$check = function (string $label, callable $assert) use (&$failures): void {
    try {
        if ($assert() === false) {
            throw new RuntimeException('returned false');
        }
        echo "ok   $label\n";
    } catch (Throwable $e) {
        $failures[] = "$label: ".$e->getMessage();
        echo "FAIL $label: {$e->getMessage()}\n";
    }
};

// Instantiating a message runs its file's descriptor initOnce() chain, which is
// where a missing or duplicated dependency blows up. Class existence alone does
// not exercise that, so these are constructed rather than checked with
// class_exists().
$messages = [
    CheckPermissionRequest::class,
    CheckPermissionResponse::class,
    CheckBulkPermissionsRequest::class,
    CheckBulkPermissionsRequestItem::class,
    CheckBulkPermissionsResponse::class,
    LookupResourcesRequest::class,
    LookupResourcesResponse::class,
    LookupSubjectsRequest::class,
    LookupSubjectsResponse::class,
    ReadSchemaRequest::class,
    ReadSchemaResponse::class,
    Consistency::class,
    ObjectReference::class,
    SubjectReference::class,
    ResolvedSubject::class,
    PartialCaveatInfo::class,
];

foreach ($messages as $message) {
    $check($message, fn () => new $message() instanceof $message);
}

// Service clients are not constructed — that would open a channel — so these
// only assert the generated class survived regeneration.
foreach ([PermissionsServiceClient::class, SchemaServiceClient::class] as $class) {
    $check($class, fn () => class_exists($class));
}

// The enum values the clients branch on. A rename here silently changes
// authorization behaviour, so each one is asserted by name.
$enums = [
    CheckPermissionResponse\Permissionship::class => [
        'PERMISSIONSHIP_HAS_PERMISSION',
        'PERMISSIONSHIP_NO_PERMISSION',
        'PERMISSIONSHIP_CONDITIONAL_PERMISSION',
    ],
    LookupPermissionship::class => [
        'LOOKUP_PERMISSIONSHIP_HAS_PERMISSION',
        'LOOKUP_PERMISSIONSHIP_CONDITIONAL_PERMISSION',
    ],
];

foreach ($enums as $enum => $values) {
    foreach ($values as $value) {
        $check("$enum::$value", fn () => defined("$enum::$value"));
    }
}

// Field accessors the clients call by name. Generated getters are renamed when
// upstream renames a field, which composes silently with a nullable return.
$accessors = [
    [CheckPermissionResponse::class, 'getPermissionship'],
    [CheckPermissionResponse::class, 'hasPartialCaveatInfo'],
    [LookupResourcesResponse::class, 'getResourceObjectId'],
    [LookupSubjectsResponse::class, 'getSubject'],
    [ResolvedSubject::class, 'getSubjectObjectId'],
    [PartialCaveatInfo::class, 'getMissingRequiredContext'],
    [ReadSchemaResponse::class, 'getSchemaText'],
];

foreach ($accessors as [$class, $method]) {
    $check("$class::$method()", fn () => method_exists($class, $method));
}

if ($failures !== []) {
    fwrite(STDERR, "\n".count($failures)." check(s) failed\n");
    exit(1);
}

echo "\nAll checks passed.\n";
