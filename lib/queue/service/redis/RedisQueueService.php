<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/16
 * Time: 4:39 PM
 */

namespace ZZQueueService\service\redis;

use ZZQueueService\service\ServiceInterface;

class RedisQueueService implements ServiceInterface {
    /**@var \ZZQueueService\service\redis\RedisQueueClient * */
    private $redisQueueClient;

    /**
     * @param array $configArray
     *
     * @throws \Exception
     * 初始化redis队列相关配置
     */
    function initConfig($configArray = []) {
        $legalParamsCheck = $this->checkConfigArray($configArray);
        if ($legalParamsCheck) {
            if (is_array($configArray['params']) &&
                array_key_exists(['options'], $configArray) &&
                is_array($configArray['options'])) {
                $redisQueueClient = new RedisQueueClient($configArray['params'],
                    $configArray['qname'], $configArray['options']);
            } else {
                $redisQueueClient
                    = new RedisQueueClient($configArray['params'],
                    $configArray['qname']);
            }
            $redisQueueClient->InitRedisQueueClient();
            $this->setRedisQueueClient($redisQueueClient);

        } else {
            throw new \Exception("初始化pulsar websocket client 参数配置不合法");
        }
    }

    /**
     * @param $msg
     *
     * @return bool
     * @throws \Exception
     * 生产消息
     */
    function produceMessage($msg) {

        if ($this->getRedisQueueClient() == null) {
            throw  new \Exception("redis queue client 生成异常");
        }

        if ( ! is_string($msg)) {
            throw  new \Exception("redis queue client 只能发送字符串");
        }

        try {
            $this->redisQueueClient->lpush($this->redisQueueClient->getQueueName(),
                $msg);
        } catch (\Exception $e) {
            return false;
        }

        return true;

    }


    /**
     * @param callable $function
     *
     * @throws \Exception
     * 消费数据
     */

    function consumerMessage(callable $function) {
        if ($this->getRedisQueueClient() == null) {
            throw  new \Exception("redis queue client 生成异常");
        }

        while (true) {
            $queueData
                = $this->redisQueueClient->rpop($this->redisQueueClient->getQueueName());
            call_user_func($function, $queueData);
        }

        // TODO: Implement consumerMessage() method.
    }

    function producerClientClose() {
        // TODO: Implement producerClientClose() method.
    }

    function consumerClientClose() {
        // TODO: Implement consumerClientClose() method.
    }

    /**
     * @return RedisQueueClient
     */
    public function getRedisQueueClient() {
        return $this->redisQueueClient;
    }

    /**
     * @param RedisQueueClient $redisQueueClient
     */
    public function setRedisQueueClient($redisQueueClient) {
        $this->redisQueueClient = $redisQueueClient;
    }


    /**
     * @param array $configArray
     *
     * @return bool
     */
    private function checkConfigArray($configArray = []) {

        if ( ! array_key_exists("params", $configArray)) {
            return false;
        }

        if ( ! array_key_exists("qname", $configArray)) {
            return false;
        }

        return true;
    }


}