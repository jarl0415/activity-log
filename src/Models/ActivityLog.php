<?php
namespace Jarl\ActivityLog\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'activity_log';
}
