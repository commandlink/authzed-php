<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Authzed\Api\Materialize\V0;

/**
 */
class RelationshipsServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * EXPERIMENTAL: CountRelationships returns the count of relationships for a given filter.
     * @param \Authzed\Api\Materialize\V0\ExperimentalCountRelationshipsByFilterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall<\Authzed\Api\Materialize\V0\ExperimentalCountRelationshipsByFilterResponse>
     */
    public function ExperimentalCountRelationshipsByFilter(\Authzed\Api\Materialize\V0\ExperimentalCountRelationshipsByFilterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/authzed.api.materialize.v0.RelationshipsService/ExperimentalCountRelationshipsByFilter',
        $argument,
        ['\Authzed\Api\Materialize\V0\ExperimentalCountRelationshipsByFilterResponse', 'decode'],
        $metadata, $options);
    }

}
