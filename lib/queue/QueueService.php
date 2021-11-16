<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/12
 * Time: 11:36 AM
 */

namespace ZZQueueService;

class QueueService {

    const QUEUE_SERVICE_LIST
        = [
            "getPulsarQueue" => \ZZQueueService\service\pulsar\PulsarQueueService::class,
        ];


    /**
     * @param $name
     * @param $arguments
     *
     * @return \ZZQueueService\service\ServiceInterface
     * 初始化调用静态方法
     */
    public static function __callStatic($name, $arguments) {
        if (array_key_exists($name, self::QUEUE_SERVICE_LIST)) {
            $queueService = (new \ReflectionClass(self::QUEUE_SERVICE_LIST[$name]))->newInstanceArgs();
            $queueService->initConfig($arguments[0]);
            return $queueService;
        } else {
            return null;
        }

    }


}