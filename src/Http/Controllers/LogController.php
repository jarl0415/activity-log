<?php

namespace Jarl\ActivityLog\Http\Controllers;

use Dcat\Admin\Grid;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Admin;
use Illuminate\Routing\Controller;
use Jarl\ActivityLog\ActivityLogServiceProvider;
use Dcat\Admin\OperationLog\Models\OperationLog;
use Jarl\ActivityLog\Models\ActivityLog;

class LogController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title(ActivityLogServiceProvider::trans('log.title'))
            ->description(trans('admin.list'))
            ->body($this->grid());
    }

    protected function grid()
    {
        // json格式化显示
//        Admin::css('vendor/dcat-admin/dcat/css/jquery.json-viewer.css');
//        Admin::js('vendor/dcat-admin/dcat/js/jquery.json-viewer.js');
        Admin::requireAssets('@jarl.activity-log');
        Admin::script(
            <<<JS
    $(".properties").each(function () {
        $(this).jsonViewer(JSON.parse($(this).text()), { collapsed: true });
    });
JS
        );
        return Grid::make(new ActivityLog(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('log_name');
            $grid->column('description');
            $grid->column('subject_type');
            $grid->column('event');
            $grid->column('subject_id');
            $grid->column('causer_type');
            $grid->column('causer_id');
            $grid->column('properties')->setAttributes(['class' => 'properties']);
            $grid->column('batch_uuid');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableCreateButton();
            $grid->disableQuickEditButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->showColumnSelector();
            $grid->setActionClass(Grid\Displayers\Actions::class);

            $grid->model()->orderBy('id', 'desc');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('log_name', 'log_name');
                $filter->like('description', 'description');
                $filter->between('created_at')->datetime();
            });
        });
    }

    public function destroy($id)
    {
        $ids = explode(',', $id);

        OperationLog::destroy(array_filter($ids));

        return JsonResponse::make()
            ->success(trans('admin.delete_succeeded'))
            ->refresh()
            ->send();
    }
}
