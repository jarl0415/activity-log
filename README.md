## Dcat Admin Activity-log操作日志扩展
dcat-admin 基于laravel/activity-log 的自动记录模型操作日志扩展

### composer安装

```php
composer require jarl/activity-log
```
如果您希望您的日志存储在一个特殊的数据库连接中，您可以在env文件中定义`ACTIVITY_LOGGER_DB_CONNECTION`。

迁移配置文件
```php
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-config"
```

### 使用
1. 打开扩展管理页面，找到`jarl.activity-log`扩展`启用`。
2. 修改`activitylog.php`配置文件里的`default_auth_driver`属性为你定义的guard，一般后台是`admin`，前台是`web`,否则生成的日志`causer_type`和`causer_id`为`null`。
3. 在想要记录的模型类中使用引入`Jarl\ActivityLog\Http\Traits\LogsActivityTrait`
```php
use LogsActivityTrait;
```
![](https://i.imgur.com/FdKVXoq.png)
### 自定义使用 (即不通过安装扩展方式使用)
例如 
1. 你添加了其他字段比如ip字段
2. 你想修改表名
3. 你想修改展示页面 
4. ...

可自行复制修改sql迁移文件、控制器、模型、静态文件、语言包等文件，之后在模型里定义`tapActivity`方法,该方法可修改任意字段。

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
### 说明

本项目基于 [spatie/laravel/activity-log](https://github.com/spatie/laravel-activitylog) 项目，如涉及侵权问题麻烦联系本人删除该项目

### 感谢

- [dcat-admin](https://github.com/jqhph/dcat-admin)
- [spatie/laravel/activity-log](https://github.com/spatie/laravel-activitylog)



License
------------

Licensed under [The MIT License (MIT)](LICENSE).