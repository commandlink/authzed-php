# commandlink/authzed-php

Generated PHP gRPC client stubs for the [SpiceDB](https://authzed.com/docs) (Authzed) **v1** API.

AuthZed publishes official SpiceDB clients for Go, Node, Python, Ruby, Java and
.NET — but **not PHP**. This package is the PHP gap, filled by generating stubs
from AuthZed's published protos and committing the output.

It contains **only generated code**. There is no CommandLink logic here: no
schema knowledge, no permission names, no feature flags, no retry policy. Those
belong in each application's own `RebacService`.

## Why this exists as a package

The stubs were originally generated into both `commandlink-api-laravel` and the
Yii application independently. That meant two copies of 155 files and two
generators, which drift the moment one side moves to a newer Authzed API. Here
the version lives in each consumer's `composer.lock`, so drift becomes
impossible rather than merely visible.

## Installing

Private repository, so add the VCS source once per consumer:

```jsonc
{
  "repositories": [
    { "type": "vcs", "url": "git@github.com:commandlink/authzed-php.git" }
  ],
  "require": {
    "commandlink/authzed-php": "^1.0"
  }
}
```

```bash
composer require commandlink/authzed-php
```

`ext-grpc` is a hard requirement, not a suggestion. The message classes would
load without it, but every service client is inert — so it is declared so a
misconfigured environment fails at install time rather than inside the first
authorization check.

## Using it

```php
use Authzed\Api\V1\CheckPermissionRequest;
use Authzed\Api\V1\Consistency;
use Authzed\Api\V1\ObjectReference;
use Authzed\Api\V1\PermissionsServiceClient;
use Authzed\Api\V1\SubjectReference;
use Grpc\ChannelCredentials;

$client = new PermissionsServiceClient('spicedb:50051', [
    'credentials' => ChannelCredentials::createInsecure(),
]);

$request = (new CheckPermissionRequest())
    ->setConsistency((new Consistency())->setMinimizeLatency(true))
    ->setResource((new ObjectReference())->setObjectType('account')->setObjectId('1234'))
    ->setPermission('view')
    ->setSubject((new SubjectReference())->setObject(
        (new ObjectReference())->setObjectType('user')->setObjectId('42')
    ));

[$response, $status] = $client
    ->CheckPermission($request, ['authorization' => ['Bearer '.$key]], ['timeout' => 1_000_000])
    ->wait();
```

Two things worth knowing before writing that by hand:

- **The preshared key goes in per-call metadata, not on the channel.** Composing
  call credentials onto a channel requires TLS, which makes plaintext local
  development impossible.
- **gRPC deadlines are microseconds**, so a 1000 ms budget is `1_000_000`.

Both are already handled by the `RebacService` in each application — prefer
those over talking to these stubs directly.

## Regenerating

The output in `gen/` is committed, so this only runs when moving to a newer
Authzed API.

```bash
brew install bufbuild/buf/buf
composer install
composer generate      # or: bash scripts/generate_authzed_stubs.sh
```

It takes three steps rather than a plain `buf generate`, because that does not
work for PHP:

1. Build a `FileDescriptorSet` from the published module.
2. Strip the proto2 validation dependencies the PHP generator refuses to compile
   (`scripts/strip_authzed_descriptors.php`).
3. Generate, then delete output for protos whose PHP classes already ship in
   `google/protobuf` and `google/common-protos` — leaving them would declare
   those classes twice.

Then `composer verify` smoke-checks that the result actually loads. A descriptor
pool problem in generated protobuf code otherwise surfaces for the first time
inside a live authorization check.

### Known gap: the source module is unpinned

`generate_authzed_stubs.sh` defaults to `buf.build/authzed/api` with no version,
so a regeneration silently tracks whatever is current. The script now records
what it resolved in `gen/.authzed-module`, but the stubs committed before that
was added carry no marker — their exact provenance is unknown.

Pass a pinned reference to make a regeneration reproducible:

```bash
bash scripts/generate_authzed_stubs.sh buf.build/authzed/api:<commit>
```

## Versioning

Semver on **this package**, not on the Authzed API — a regeneration that only
adds messages is a minor, one that removes or renames anything callers touch is
a major, regardless of what AuthZed called it. `gen/.authzed-module` records
which upstream revision a given release was built from.

## Consumers

- `commandlink-api-laravel` — `App\Services\Rebac\RebacService`
- CommandLink (Yii) — `RebacService`

Those two are deliberately converged: same method names, same argument shapes,
same semantics. Change one and change the other.
