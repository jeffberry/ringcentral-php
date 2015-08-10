<?php

namespace RingCentral\SDK;

use RingCentral\SDK\Http\Client;
use RingCentral\SDK\Http\MultipartBuilder;
use RingCentral\SDK\Platform\Platform;
use RingCentral\SDK\Pubnub\PubnubFactory;
use RingCentral\SDK\Subscription\Subscription;

class SDK
{

    const VERSION = '0.6.0';
    const SERVER_PRODUCTION = 'https://platform.ringcentral.com';
    const SERVER_SANDBOX = 'https://platform.devtest.ringcentral.com';

    /** @var Platform */
    protected $platform;

    /** @var PubnubFactory */
    protected $pubnubFactory;

    /** @var Client */
    protected $client;

    public function __construct(
        $appKey,
        $appSecret,
        $server
    ) {

        $this->pubnubFactory = new PubnubFactory();
        $this->client = new Client();
        $this->platform = new Platform($this->client, $appKey, $appSecret, $server);

    }

    public function getPlatform()
    {
        return $this->platform;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getPubnubFactory()
    {
        return $this->pubnubFactory;
    }

    public function getSubscription()
    {
        return new Subscription($this->pubnubFactory, $this->platform);
    }

    public function getMultipartBuilder()
    {
        return new MultipartBuilder();
    }

}