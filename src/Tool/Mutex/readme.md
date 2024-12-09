### 使用示例

```php 
<?php

require_once __DIR__ . '/vendor/composer/autoload_real.php';
ComposerAutoloaderInit5b16528999c1beb466aaefe9037c5b65::getLoader();
try {
    Mutex::getLock('test:123')->synchronized(function () {
        return true;
    }, 100);
} catch (Exception $exception) {
    dd($exception);
}
```

