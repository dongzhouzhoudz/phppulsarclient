<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/12
 * Time: 11:36 AM
 */

namespace ZZQueueService;

class QueueService {

    /**@var \ZZQueueService\service\ServiceInterface * */
    private static $queueService;

    const QUEUE_SERVICE_LIST
        = [
            "getPulsarQueue" => \ZZQueueService\service\pulsar\PulsarQueueService::class,
        ];


    /**
     * @param $name
     * @param $arguments
     *
     * @return object|service\ServiceInterface
     * @throws \Exception
     * 初始化调用静态方法
     */
    public static function __callStatic($name, $arguments) {
        if (array_key_exists($name, self::QUEUE_SERVICE_LIST)) {
            self::$queueService
                = (new \ReflectionClass(self::QUEUE_SERVICE_LIST[$name]))->newInstanceArgs();
            self::$queueService->initConfig($arguments);

            return self::$queueService;
        } else {
            throw  new \Exception("Init Queue Service Error---".
                "Can Not Find Function Name : ".$name);
        }


    }

}