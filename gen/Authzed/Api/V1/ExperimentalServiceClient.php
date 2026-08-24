<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Authzed\Api\V1;

/**
 * ExperimentalService exposes a number of APIs that are currently being
 * prototyped and tested for future inclusion in the stable API.
 */
class ExperimentalServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to ImportBulkRelationships in the stable API.
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ClientStreamingCall
     */
    public function BulkImportRelationships($metadata = [], $options = []) {
        return $this->_clientStreamRequest('/authzed.api.v1.ExperimentalService/BulkImportRelationships',
        ['\Authzed\Api\V1\BulkImportRelationshipsResponse','decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to ExportBulkRelationships in the stable API.
     * @param \Authzed\Api\V1\BulkExportRelationshipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function BulkExportRelationships(\Authzed\Api\V1\BulkExportRelationshipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/authzed.api.v1.ExperimentalService/BulkExportRelationships',
        $argument,
        ['\Authzed\Api\V1\BulkExportRelationshipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to CheckBulkPermission in the stable API.
     * @param \Authzed\Api\V1\BulkCheckPermissionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\BulkCheckPermissionResponse>
     */
    public function BulkCheckPermission(\Authzed\Api\V1\BulkCheckPermissionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/BulkCheckPermission',
        $argument,
        ['\Authzed\Api\V1\BulkCheckPermissionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to ReflectSchema in the stable API.
     * @param \Authzed\Api\V1\ExperimentalReflectSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalReflectSchemaResponse>
     */
    public function ExperimentalReflectSchema(\Authzed\Api\V1\ExperimentalReflectSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalReflectSchema',
        $argument,
        ['\Authzed\Api\V1\ExperimentalReflectSchemaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to ComputablePermissions in the stable API.
     * @param \Authzed\Api\V1\ExperimentalComputablePermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalComputablePermissionsResponse>
     */
    public function ExperimentalComputablePermissions(\Authzed\Api\V1\ExperimentalComputablePermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalComputablePermissions',
        $argument,
        ['\Authzed\Api\V1\ExperimentalComputablePermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to DependentRelations in the stable API.
     * @param \Authzed\Api\V1\ExperimentalDependentRelationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalDependentRelationsResponse>
     */
    public function ExperimentalDependentRelations(\Authzed\Api\V1\ExperimentalDependentRelationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalDependentRelations',
        $argument,
        ['\Authzed\Api\V1\ExperimentalDependentRelationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * @deprecated
     * DEPRECATED: Promoted to DiffSchema in the stable API.
     * @param \Authzed\Api\V1\ExperimentalDiffSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalDiffSchemaResponse>
     */
    public function ExperimentalDiffSchema(\Authzed\Api\V1\ExperimentalDiffSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalDiffSchema',
        $argument,
        ['\Authzed\Api\V1\ExperimentalDiffSchemaResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * EXPERIMENTAL: RegisterRelationshipCounter registers a new filter for counting relationships. A filter must be registered before
     * a count can be requested.
     * @param \Authzed\Api\V1\ExperimentalRegisterRelationshipCounterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalRegisterRelationshipCounterResponse>
     */
    public function ExperimentalRegisterRelationshipCounter(\Authzed\Api\V1\ExperimentalRegisterRelationshipCounterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalRegisterRelationshipCounter',
        $argument,
        ['\Authzed\Api\V1\ExperimentalRegisterRelationshipCounterResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * EXPERIMENTAL: CountRelationships returns the count of relationships for *pre-registered* filter.
     * @param \Authzed\Api\V1\ExperimentalCountRelationshipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalCountRelationshipsResponse>
     */
    public function ExperimentalCountRelationships(\Authzed\Api\V1\ExperimentalCountRelationshipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalCountRelationships',
        $argument,
        ['\Authzed\Api\V1\ExperimentalCountRelationshipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * EXPERIMENTAL: UnregisterRelationshipCounter unregisters an existing filter for counting relationships.
     * @param \Authzed\Api\V1\ExperimentalUnregisterRelationshipCounterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExperimentalUnregisterRelationshipCounterResponse>
     */
    public function ExperimentalUnregisterRelationshipCounter(\Authzed\Api\V1\ExperimentalUnregisterRelationshipCounterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.ExperimentalService/ExperimentalUnregisterRelationshipCounter',
        $argument,
        ['\Authzed\Api\V1\ExperimentalUnregisterRelationshipCounterResponse', 'decode'],
        $metadata, $options);
    }

}
