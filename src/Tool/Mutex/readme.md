使用示例

    public function testAction()
    {
        try {
            Mutex::register(RedisMutexProvider::getMutexProvider($redis));
            $lockName = 'zshi:123' . $id;
            Mutex::getLock($lockName)->synchronized(function () {
                ddd(1234);
                return true;
            }, 1000);
        } catch (\Throwable $e) {
        }
        $this->returnJson(parent::STATUS_OK, '', $result ?? null);
    }