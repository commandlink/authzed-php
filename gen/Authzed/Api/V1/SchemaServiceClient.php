<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Authzed\Api\V1;

/**
 * SchemaService implements operations on a Permissions System's Schema.
 */
class SchemaServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Read returns the current Object Definitions for a Permissions System.
     *
     * Errors include:
     * - INVALID_ARGUMENT: a provided value has failed to semantically validate
     * - NOT_FOUND: no schema has been defined
     * @param \Authzed\Api\V1\ReadSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ReadSchemaResponse>
     */
    public function ReadSchema(\Authzed\Api\V1\ReadSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.SchemaService/ReadSchema',
        $argument,
        ['\Authzed\Api\V1\ReadSchemaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Write overwrites the current Object Definitions for a Permissions System.
     * @param \Authzed\Api\V1\WriteSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\WriteSchemaResponse>
     */
    public function WriteSchema(\Authzed\Api\V1\WriteSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.SchemaService/WriteSchema',
        $argument,
        ['\Authzed\Api\V1\WriteSchemaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ReflectSchema reflects the current schema stored in SpiceDB, returning a structural
     * form of the schema for use by client tooling.
     * @param \Authzed\Api\V1\ReflectSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ReflectSchemaResponse>
     */
    public function ReflectSchema(\Authzed\Api\V1\ReflectSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.SchemaService/ReflectSchema',
        $argument,
        ['\Authzed\Api\V1\ReflectSchemaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ComputablePermissions returns the set of permissions that compute based off a relation
     * in the current schema. For example, if the schema has a relation `viewer` and a permission
     * `view` defined as `permission view = viewer + editor`, then the
     * computable permissions for the relation `viewer` will include `view`.
     * @param \Authzed\Api\V1\ComputablePermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ComputablePermissionsResponse>
     */
    public function ComputablePermissions(\Authzed\Api\V1\ComputablePermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.SchemaService/ComputablePermissions',
        $argument,
        ['\Authzed\Api\V1\ComputablePermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * DependentRelations returns the set of relations and permissions that used
     * to compute a permission, recursively, in the current schema. It is the
     * inverse of the ComputablePermissions API.
     * @param \Authzed\Api\V1\DependentRelationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\DependentRelationsResponse>
     */
    public function DependentRelations(\Authzed\Api\V1\DependentRelationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.SchemaService/DependentRelations',
        $argument,
        ['\Authzed\Api\V1\DependentRelationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * DiffSchema returns the difference between the specified schema and the current
     * schema stored in SpiceDB.
     * @param \Authzed\Api\V1\DiffSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\DiffSchemaResponse>
     */
    public function DiffSchema(\Authzed\Api\V1\DiffSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.SchemaService/DiffSchema',
        $argument,
        ['\Authzed\Api\V1\DiffSchemaResponse', 'decode'],
        $metadata, $options);
    }

}
