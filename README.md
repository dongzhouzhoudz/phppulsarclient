# phppulsarclient
PHP Pulsar Client WebSocket 

## This Client Is For Php Queue Service 
### Now Just Contain pulsar and redis client
#### How To Use Pulsar Queue Service
```php

 use ZZQueueService\QueueService;
 
 $queueService = QueueService::getPulsarQueue([
             "url" => "111.111.0.60:8080",
             "tenant"=>"socket",
             "namespace"=>"socket_namespace",
             "topic"=>"socket_topic"
         ]);
 
 $array = ["a"=>"b","c"=>"d"];
 for ($i=0;$i<100;$i++) {
         $queueService->produceMessage($array);
         sleep(2);
   }


```

#### How To Use Redis Queue Service

```php

       $queueService = QueueService::getRedisQueue(["params"=>'tcp://192.168.33.30:6379',"qname"=>"test_redis_queue"]);
        $queueService->produceMessage("show me code");

        $queueService->consumerMessage(function($msg){
            print_r($msg);
        });


```



