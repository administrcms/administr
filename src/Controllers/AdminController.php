<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17.3.2016 г.
 * Time: 14:49 ч.
 */

namespace Administr\Controllers;

use Administr\Form\Form;
use Administr\ListView\ListView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

abstract class AdminController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var Form
     */
    protected $form;

    public function __construct()
    {
        $this->form = app($this->form);
    }

    public function index()
    {
        $list = $this->getListView();
        return view('administr::admin.list', compact('list'));
    }

    public function create()
    {
        $form = $this->form;

        $form->action = $this->getStoreAction();
        $form->method = 'post';

        return view('administr::admin.form', compact('form'));
    }

    public function edit($id)
    {
        $model = $this->getModel($id);

        $form = $this->form;
        $form->action = $this->getUpdateAction($id);
        $form->method = 'put';
        $form->setDataSource($model);

        return view('administr::admin.form', compact('model', 'form'));
    }

    public function destroy($id)
    {
        $model = $this->getModel($id)->delete();
    }

    /**
     * Get a configured instance of the ListView for the resource.
     *
     * @return ListView
     */
    abstract public function getListView();

    /**
     * Get the action URL for storing data.
     *
     * @return string
     */
    abstract public function getStoreAction();

    /**
     * Get the action URL for updating data.
     *
     * @param $id
     * @return string
     */
    abstract public function getUpdateAction($id);

    /**
     * Get an instance of the model for a record.
     *
     * @param $id
     * @return Model
     */
    abstract public function getModel($id);
}