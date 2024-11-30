使用示例

    public function testAction()
    {
        try {
            $redis = $this->di->get('redisM');
            RedisApplication::register($redis);
            Mutex::register(MutexProviderByRedis::getMutexProvider());
            $result = Mutex::getLock('zshi:test:800')->synchronized(function () {
                return 123;
            }, 1000);
        } catch (\Throwable $e) {
        }
        $this->returnJson(parent::STATUS_OK, '', $result ?? null);
    }