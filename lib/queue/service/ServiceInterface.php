<?php
/**
 * Created by PhpStorm.
 * User: dongzhou
 * Date: 2021/11/12
 * Time: 11:38 AM
 */
namespace  ZZQueueService\service;

interface ServiceInterface {
    function initConfig($configArray=[]);
    function produceMessage($msg);
    function consumerMessage(callable  $function);
    function producerClientClose();
    function consumerClientClose();

}