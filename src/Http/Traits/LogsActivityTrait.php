<?php

namespace Jarl\ActivityLog\Http\Traits;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

trait LogsActivityTrait
{
    use LogsActivity;

    protected $logName = '';

    protected function getDescriptionForEvent(string $eventName): string
    {
        $description = '';
        switch ($eventName) {
            case 'created':
                $description = '管理员' . Auth('admin')->user()->username . '添加了' . $this->table . '表id为' . $this->id . '的数据';
                break;
            case 'updated':
                $description = '管理员' . Auth('admin')->user()->username . '修改了' . $this->table . '表id为' . $this->id . '的数据';
                break;
            case 'deleted':
                $description = '管理员' . Auth('admin')->user()->username . '删除了' . $this->table . '表id为' . $this->id . '的数据';
                break;
        }
        return $description;
    }

    protected function getLogName(): string
    {
        return $this->logName ?: strtolower(class_basename($this));
    }

    protected function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // 记录所有字段的更改
            ->dontLogIfAttributesChangedOnly(['updated_at']) // 当只有updated_at 字段更改时不记录
            ->logOnlyDirty() // 只有实际发生更改的字段记录
            ->dontSubmitEmptyLogs() // 不记录空日志
            ->useLogName($this->getLogName()) // 设置日志名
            ->setDescriptionForEvent(function (string $eventName) {
                return $this->getDescriptionForEvent($eventName);
            });
    }
}
