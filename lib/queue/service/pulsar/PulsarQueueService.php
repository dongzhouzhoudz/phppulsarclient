<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/12
 * Time: 11:41 AM
 */

namespace ZZQueueService\service\pulsar;

use ZZQueueService\service\ServiceInterface;


class PulsarQueueService implements ServiceInterface {

    /**@var \ZZQueueService\service\pulsar\PulsarQueueClient */
    private $pulsarQueueClient;

    /**
     * @param $configArray
     *
     * @throws \Exception
     * 参数初始化
     */
    function initConfig($configArray = []) {

        $legalParamsCheck = $this->checkConfigArray($configArray);

        if ($legalParamsCheck) {
            $subscribeName = $configArray['subname'] ?? "";
            $pulsarQueueClient = new PulsarQueueClient($configArray['url'],
                $configArray['tenant'], $configArray['namespace'],
                $configArray['topic'], $subscribeName);
            $pulsarQueueClient->InitWebSocketClient();
            $this->setPulsarQueueClient($pulsarQueueClient);
        } else {
            throw new \Exception("初始化pulsar websocket client 参数配置不合法");
        }
    }


    /**
     * @param $message
     *
     * @return bool
     * @throws \Exception
     * 生产数据，发送队列信息
     */
    function produceMessage($message) {
        //队列发送说明
        if ($this->getPulsarQueueClient() == null) {
            throw  new \Exception("pulsar queue client 生成异常");

        }
        //获取生产者实例
        $producerClient = $this->getPulsarQueueClient()
            ->getWebSocketProducerClient();

        if ($producerClient == null) {
            throw new \Exception("pulsar queue producer 生成异常");
        }


        //判断是否是数组类型
        if (is_array($message)) {
            $message = json_encode($message);
        }

        //发送前需要base64
        $base64Message = base64_encode($message);

        $prepareSendMessage = [
            "payload"    => $base64Message,
            "properties" => new \stdClass(),
            "context"    => "",
            "key"        => "",
        ];

        $sendMessage = json_encode($prepareSendMessage);
        $sendResult = $producerClient->text($sendMessage);
        try {
            $result = json_decode($sendResult);
            if (array_key_exists("result", $result) &&
                $result['result'] == "ok") {
                return true;

            } else {
                throw new \Exception("Pulsar Php WebSocket Client Send Error----".
                    $result);
            }
        } catch (\Exception $e) {
            throw new \Exception("Pulsar Php Send Error ---".$e->getMessage());
        }


    }

    function consumerMessage() {

    }

    /**
     * @return PulsarQueueClient
     */
    public function getPulsarQueueClient() {
        return $this->pulsarQueueClient;
    }

    /**
     * @param PulsarQueueClient $pulsarQueueClient
     */
    public function setPulsarQueueClient($pulsarQueueClient) {
        $this->pulsarQueueClient = $pulsarQueueClient;
    }


    /**
     * @param array $configArray
     *
     * @return bool
     * 校验必要参数传递
     */
    private function checkConfigArray($configArray = []) {
        if ( ! array_key_exists("url", $configArray)) {
            return false;
        }

        if ( ! array_key_exists("tenant", $configArray)) {
            return false;
        }

        if ( ! array_key_exists("namespace", $configArray)) {
            return false;
        }


        if ( ! array_key_exists("topic", $configArray)) {
            return false;
        }

        return true;
    }

}
