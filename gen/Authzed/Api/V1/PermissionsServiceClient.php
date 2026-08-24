<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Authzed\Api\V1;

/**
 * PermissionsService implements a set of RPCs that perform operations on
 * relationships and permissions.
 */
class PermissionsServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * ReadRelationships reads a set of the relationships matching one or more
     * filters.
     * @param \Authzed\Api\V1\ReadRelationshipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function ReadRelationships(\Authzed\Api\V1\ReadRelationshipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/authzed.api.v1.PermissionsService/ReadRelationships',
        $argument,
        ['\Authzed\Api\V1\ReadRelationshipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * WriteRelationships atomically writes and/or deletes a set of specified
     * relationships. An optional set of preconditions can be provided that must
     * be satisfied for the operation to commit.
     * @param \Authzed\Api\V1\WriteRelationshipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\WriteRelationshipsResponse>
     */
    public function WriteRelationships(\Authzed\Api\V1\WriteRelationshipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.PermissionsService/WriteRelationships',
        $argument,
        ['\Authzed\Api\V1\WriteRelationshipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * DeleteRelationships atomically bulk deletes all relationships matching the
     * provided filter. If no relationships match, none will be deleted and the
     * operation will succeed. An optional set of preconditions can be provided that must
     * be satisfied for the operation to commit.
     * @param \Authzed\Api\V1\DeleteRelationshipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\DeleteRelationshipsResponse>
     */
    public function DeleteRelationships(\Authzed\Api\V1\DeleteRelationshipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.PermissionsService/DeleteRelationships',
        $argument,
        ['\Authzed\Api\V1\DeleteRelationshipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * CheckPermission determines for a given resource whether a subject computes
     * to having a permission or is a direct member of a particular relation.
     * @param \Authzed\Api\V1\CheckPermissionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\CheckPermissionResponse>
     */
    public function CheckPermission(\Authzed\Api\V1\CheckPermissionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.PermissionsService/CheckPermission',
        $argument,
        ['\Authzed\Api\V1\CheckPermissionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * CheckBulkPermissions evaluates the given list of permission checks
     * and returns the list of results.
     * @param \Authzed\Api\V1\CheckBulkPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\CheckBulkPermissionsResponse>
     */
    public function CheckBulkPermissions(\Authzed\Api\V1\CheckBulkPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.PermissionsService/CheckBulkPermissions',
        $argument,
        ['\Authzed\Api\V1\CheckBulkPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ExpandPermissionTree reveals the graph structure for a resource's
     * permission or relation. This RPC does not recurse infinitely deep and may
     * require multiple calls to fully unnest a deeply nested graph.
     * @param \Authzed\Api\V1\ExpandPermissionTreeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\V1\ExpandPermissionTreeResponse>
     */
    public function ExpandPermissionTree(\Authzed\Api\V1\ExpandPermissionTreeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.v1.PermissionsService/ExpandPermissionTree',
        $argument,
        ['\Authzed\Api\V1\ExpandPermissionTreeResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * LookupResources returns all the resources of a given type that a subject
     * can access whether via a computed permission or relation membership.
     * @param \Authzed\Api\V1\LookupResourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function LookupResources(\Authzed\Api\V1\LookupResourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/authzed.api.v1.PermissionsService/LookupResources',
        $argument,
        ['\Authzed\Api\V1\LookupResourcesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * LookupSubjects returns all the subjects of a given type that
     * have access whether via a computed permission or relation membership.
     * @param \Authzed\Api\V1\LookupSubjectsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function LookupSubjects(\Authzed\Api\V1\LookupSubjectsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/authzed.api.v1.PermissionsService/LookupSubjects',
        $argument,
        ['\Authzed\Api\V1\LookupSubjectsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ImportBulkRelationships is a faster path to writing a large number of
     * relationships at once. It is both batched and streaming. For maximum
     * performance, the caller should attempt to write relationships in as close
     * to relationship sort order as possible: (resource.object_type,
     * resource.object_id, relation, subject.object.object_type,
     * subject.object.object_id, subject.optional_relation). All relationships
     * written are done so under a single transaction.
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ClientStreamingCall
     */
    public function ImportBulkRelationships($metadata = [], $options = []) {
        return $this->_clientStreamRequest('/authzed.api.v1.PermissionsService/ImportBulkRelationships',
        ['\Authzed\Api\V1\ImportBulkRelationshipsResponse','decode'],
        $metadata, $options);
    }

    /**
     * ExportBulkRelationships is the fastest path available to exporting
     * relationships from the server. It is resumable, and will return results
     * in an order determined by the server.
     * @param \Authzed\Api\V1\ExportBulkRelationshipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function ExportBulkRelationships(\Authzed\Api\V1\ExportBulkRelationshipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/authzed.api.v1.PermissionsService/ExportBulkRelationships',
        $argument,
        ['\Authzed\Api\V1\ExportBulkRelationshipsResponse', 'decode'],
        $metadata, $options);
    }

}
