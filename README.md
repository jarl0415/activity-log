## Dcat Admin Activity-log操作日志扩展
dcat-admin 基于laravel/activity-log 的自动记录模型操作日志扩展

### composer安装

```php
composer require jarl/activity-log
```
如果您希望您的日志存储在一个特殊的数据库连接中，您可以在env文件中定义`ACTIVITY_LOGGER_DB_CONNECTION`。

迁移数据库文件

```php
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
```
根据需要可以修改迁移文件 例如添加`ip`字段
发布迁移后 你可以通过运行迁移来创建表
```php
php artisan migrate
```
迁移配置文件
```php
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
```

### 使用

在想要记录的模型类中使用引入`Jarl\ActivityLog\Http\Traits\LogsActivityTrait`
```php
use LogsActivityTrait;
```
修改`activitylog.php`配置文件里的`default_auth_driver`属性为你定义的guard，一般后台是`admin`，前台是`web`,否则生成的日志`causer_type`和`causer_id`为`null`。

如果你添加了其他字段比如ip字段，可在模型里定义`tapActivity`方法,该方法可修改任意字段。

```php
use Jarl\ActivityLog\Http\Traits\LogsActivityTrait;
use Spatie\Activitylog\Models\Activity;
......

class User extends Model{
    ...
    use LogsActivityTrait;
    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->ip = request()->ip();
        $activity->causer_id = 2;
        //$activity->description = '你想要修改的description';
    }
}

```
同时也可查看activity-log[官方文档](https://spatie.be/docs/laravel-activitylog/v4/introduction)使用，
### `zip`压缩包安装
1. 首先要安装laravel/activity-log4.0版本`composer require spatie/laravel-activitylog 4.0.0`
2. 发布配置文件,不发布迁移文件,修改配置文件
3. 下载`zip`压缩包，打开扩展管理页面，点击`本地安装`按钮选择提交，点击`启用`按钮，自行修改。
4. 使用同上
5. 其中日志展示页面我使用了[jquery.json-viewer](https://github.com/abodelot/jquery.json-viewer)进行json格式化展示，可自行修改，通过composer安装的也可参考使用。
    - 注意 默认表名是`activity-log`，如果你在activitylog.php修改了表名，则需修改`model`里`$table`。
      ![](https://i.imgur.com/FdKVXoq.png)