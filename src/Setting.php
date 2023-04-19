<?php

namespace Jarl\ActivityLog;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function title()
    {
        return $this->trans('log.title');
    }

    public function form()
    {
//        $this->text('key1')->required();
//        $this->text('key2')->required();
    }
}
