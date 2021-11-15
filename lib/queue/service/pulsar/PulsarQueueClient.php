<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/12
 * Time: 11:43 AM
 */

namespace ZZQueueService\service\pulsar;

use WebSocket\Client;

class PulsarQueueClient {
    private $webSocketProducerClient;
    private $webSocketConsumerClient;
    private $brokerServiceUrl;
    private $tenant;
    private $namespace;
    private $topic;
    private $subscribeName;
    private $producerWSUrl;
    private $consumerWSUrl;

    /**
     * PulsarQueueClient constructor.
     *
     * @param        $brokerServiceUrl
     * @param        $tenant
     * @param        $namespace
     * @param        $topic
     * @param string $subscribeName
     * 对象初始化
     */
    public function __construct($brokerServiceUrl, $tenant, $namespace, $topic,
        $subscribeName = "") {
        $this->setBrokerServiceUrl($brokerServiceUrl);
        $this->setTenant($tenant);
        $this->setNamespace($namespace);
        $this->setTopic($topic);
        $this->setSubscribeName($subscribeName);
        $this->setWebSocketProducerClient(null);
        $this->setWebSocketConsumerClient(null);
    }

    /**
     * 初始化socketclient
     */
    public function InitWebSocketClient() {
        $this->setProducerWSUrl("ws://".$this->getBrokerServiceUrl()."/ws/v2/producer/persistent/".$this->getTenant()."/".$this->getNamespace()."/".$this->getTopic()."/".$this->getSubscribeName());
        $producerClient = new Client($this->getProducerWSUrl());
        $this->setWebSocketProducerClient($producerClient);
        $this->setProducerWSUrl($producerClient);
        if($this->getSubscribeName()!=""){
            $this->setConsumerWSUrl("ws://".$this->getBrokerServiceUrl()."/ws/v2/consumer/persistent/".$this->getTenant()."/".$this->getNamespace()."/".$this->getTopic()."/".$this->getSubscribeName());
            $consumerClient = new Client($this->getConsumerWSUrl());
            $this->setWebSocketConsumerClient($consumerClient);
        }
    }

    /**
     * @return mixed
     */
    public function getWebSocketProducerClient() {
        return $this->webSocketProducerClient;
    }

    /**
     * @param mixed $webSocketProducerClient
     */
    public function setWebSocketProducerClient($webSocketProducerClient) {
        $this->webSocketProducerClient = $webSocketProducerClient;
    }

    /**
     * @return mixed
     */
    public function getWebSocketConsumerClient() {
        return $this->webSocketConsumerClient;
    }

    /**
     * @param mixed $webSocketConsumerClient
     */
    public function setWebSocketConsumerClient($webSocketConsumerClient) {
        $this->webSocketConsumerClient = $webSocketConsumerClient;
    }






    /**
     * @return mixed
     */
    public function getBrokerServiceUrl() {
        return $this->brokerServiceUrl;
    }

    /**
     * @param mixed $brokerServiceUrl
     */
    public function setBrokerServiceUrl($brokerServiceUrl) {
        $this->brokerServiceUrl = $brokerServiceUrl;
    }

    /**
     * @return mixed
     */
    public function getTenant() {
        return $this->tenant;
    }

    /**
     * @param mixed $tenant
     */
    public function setTenant($tenant) {
        $this->tenant = $tenant;
    }

    /**
     * @return mixed
     */
    public function getNamespace() {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace($namespace) {
        $this->namespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getTopic() {
        return $this->topic;
    }

    /**
     * @param mixed $topic
     */
    public function setTopic($topic) {
        $this->topic = $topic;
    }

    /**
     * @return mixed
     */
    public function getSubscribeName() {
        return $this->subscribeName;
    }

    /**
     * @param mixed $subscribeName
     */
    public function setSubscribeName($subscribeName) {
        $this->subscribeName = $subscribeName;
    }

    /**
     * @return mixed
     */
    public function getProducerWSUrl() {
        return $this->producerWSUrl;
    }

    /**
     * @param mixed $producerWSUrl
     */
    public function setProducerWSUrl($producerWSUrl) {
        $this->producerWSUrl = $producerWSUrl;
    }

    /**
     * @return mixed
     */
    public function getConsumerWSUrl() {
        return $this->consumerWSUrl;
    }

    /**
     * @param mixed $consumerWSUrl
     */
    public function setConsumerWSUrl($consumerWSUrl) {
        $this->consumerWSUrl = $consumerWSUrl;
    }

    /**
     * @return mixed
     */
    public function getClientType() {
        return $this->clientType;
    }

    /**
     * @param mixed $clientType
     */
    public function setClientType($clientType) {
        $this->clientType = $clientType;
    }






}