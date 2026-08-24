<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Authzed\Api\Materialize\V0;

/**
 */
class WatchPermissionsServiceClient extends \Grpc\BaseStub {

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
     * WatchPermissions returns a stream of PermissionChange events for the given permissions.
     *
     * WatchPermissions is a long-running RPC, and will stream events until the client
     * closes the connection or the server terminates the stream. The consumer is responsible of
     * keeping track of the last seen revision and resuming the stream from that point in the event
     * of disconnection or client-side restarts.
     *
     * The API does not offer a sharding mechanism and thus there should only be one consumer per target system.
     * Implementing an active-active HA consumer setup over the same target system will require coordinating which
     * revisions have been consumed in order to prevent transitioning to an inconsistent state.
     *
     * Usage of WatchPermissions requires to be explicitly enabled on the service, including the permissions to be
     * watched. It requires more resources and is less performant than WatchPermissionsSets. It's usage
     * is only recommended when performing the set intersections of WatchPermissionSets in the client side is not viable
     * or there is a strict application requirement to use consume the computed permissions.
     * @param \Authzed\Api\Materialize\V0\WatchPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function WatchPermissions(\Authzed\Api\Materialize\V0\WatchPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/authzed.api.materialize.v0.WatchPermissionsService/WatchPermissions',
        $argument,
        ['\Authzed\Api\Materialize\V0\WatchPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
