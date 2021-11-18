<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/16
 * Time: 4:38 PM
 */

namespace ZZQueueService\service\redis;

use Predis\Client;

class RedisQueueClient {
    private $configParams;
    private $configOptions;
    private $queueName;
    private $redisQueueClient;

    /**
     * RedisQueueClient constructor.
     *
     * @param       $params
     * @param array $options
     * @param       $queueName
     * 初始化参数
     */
    public function __construct($params, $queueName, $options = []) {
        $this->setConfigParams($params);
        $this->setConfigOptions($options);
        $this->setQueueName($queueName);
    }


    /**
     * 初始化RedisClient
     */
    public function InitRedisQueueClient() {
        $client = null;
        if ( ! empty($this->getConfigOptions())) {
            $client = new Client($this->getConfigParams(),
                $this->getConfigOptions());
        } else {
            $client = new Client($this->getConfigParams());
        }

        $this->setRedisQueueClient($client);
    }


    /**
     * @return mixed
     */
    public function getConfigParams() {
        return $this->configParams;
    }

    /**
     * @param mixed $configParams
     */
    public function setConfigParams($configParams) {
        $this->configParams = $configParams;
    }

    /**
     * @return mixed
     */
    public function getConfigOptions() {
        return $this->configOptions;
    }

    /**
     * @param mixed $configOptions
     */
    public function setConfigOptions($configOptions) {
        $this->configOptions = $configOptions;
    }

    /**
     * @return mixed
     */
    public function getRedisQueueClient() {
        return $this->redisQueueClient;
    }

    /**
     * @param mixed $redisQueueClient
     */
    public function setRedisQueueClient($redisQueueClient) {
        $this->redisQueueClient = $redisQueueClient;
    }

    /**
     * @return mixed
     */
    public function getQueueName() {
        return $this->queueName;
    }

    /**
     * @param mixed $queueName
     */
    public function setQueueName($queueName) {
        $this->queueName = $queueName;
    }


}