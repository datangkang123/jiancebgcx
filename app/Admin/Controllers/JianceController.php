<?php

namespace App\Admin\Controllers;

use App\Models\JianceModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class JianceController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('检测报告管理')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new JianceModel);

        //$grid->id('ID');
        $grid->bianhao('手机号或合同编号');
		$grid->pictures('扫描图片')->image();
		$grid->beizhu('备注');
        $grid->created_at('创建时间');
        $grid->updated_at('更新时间');
        $grid->quickSearch('bianhao');//快捷搜索
		//$grid->tools(function (Grid\Tools $tools) {$tools->append(new ImportPost());});//添加上传数据按钮

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(JianceModel::findOrFail($id));

        //$show->id('ID');
        $show->bianhao('手机号或合同编号');
        $show->pictures('扫描图片')->image();
        $show->beizhu('备注');
        $show->created_at('创建时间');
        $show->updated_at('更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new JianceModel);

        //$form->display('ID');
        $form->text('bianhao', '手机号或合同编号')->required();
        $form->multipleImage('pictures', '扫描图片')->removable()->sortable();//按住ctrl选择多图上传
        $form->text('beizhu', '备注');
        $form->display('Created at','创建时间');
        $form->display('Updated at','更新时间');
        $form->disableReset(); //关闭撤销键
      
        return $form;
    }
}
