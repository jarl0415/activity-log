<?php

namespace Jarl\ActivityLog;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Admin;

class ActivityLogServiceProvider extends ServiceProvider
{
	protected $js = [
        'js/jquery.json-viewer.js',
    ];
	protected $css = [
		'css/jquery.json-viewer.css',
	];

    // 定义菜单
    protected $menu = [
        [
            'title' => 'Activity Log',
            'uri'   => 'auth/activity-logs',
            'icon'  => '', // 图标可以留空
        ],
    ];

    public function settingForm()
    {
        return new Setting($this);
    }
}
