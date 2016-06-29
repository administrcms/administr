<?php

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
        if(is_null($this->form)) {
            $this->form = $this->getFormClass();
        }

        $this->form = app($this->form);
    }

    public function index()
    {
        $list = $this->getListView(func_get_args());
        return view('administr::admin.list', compact('list'));
    }

    public function create()
    {
        $form = $this->form;

        $form->action = $this->getStoreAction(func_get_args());
        $form->method = 'post';

        return view('administr::admin.form', compact('form'));
    }

    public function edit()
    {
        $args = func_get_args();

        $model = $this->getModel($args);

        $form = $this->form;
        $form->action = $this->getUpdateAction($args);
        $form->method = 'put';
        $form->setDataSource($model);

        return view('administr::admin.form', compact('model', 'form'));
    }

    public function destroy($id)
    {
        $model = $this->getModel($id)->delete();
    }

    /**
     * Show a model, if applicable.
     *
     * @param $id
     * @param string $redirectTo
     * @param string $visibleField
     * @return Response
     */
    public function show($id, $redirectTo = null, $visibleField = 'is_visible')
    {
        $model = $this->getModel([$id]);

        $model->update([$visibleField => true]);

        if($redirectTo) {
            return redirect($redirectTo);
        }

        return back();
    }

    /**
     * Hide a model, if applicable.
     *
     * @param $id
     * @param string $redirectTo
     * @param string $visibleField
     * @return Response
     */
    public function hide($id, $redirectTo = null, $visibleField = 'is_visible')
    {
        $model = $this->getModel([$id]);

        $model->update([$visibleField => false]);

        if($redirectTo) {
            return redirect($redirectTo);
        }

        return back();
    }
    /**
     * Try to guess the corresponding form class
     * for the given controller.
     *
     * @return string
     */
    protected function getFormClass()
    {
        $class = new \ReflectionClass( get_called_class() );

        $namespace = app()->getNamespace();

        $name = str_singular(
            str_replace('Controller', '', $class->getShortName())
        );

        return sprintf('\%sHttp\Forms\%sForm', $namespace,$name);
    }

    /**
     * Get a configured instance of the ListView for the resource.
     *
     * @param array $args
     * @return ListView
     */
    abstract public function getListView(array $args = []);

    /**
     * Get the action URL for storing data.
     *
     * @param array $args
     * @return string
     */
    abstract public function getStoreAction(array $args = []);

    /**
     * Get the action URL for updating data.
     *
     * @param array $args
     * @return string
     */
    abstract public function getUpdateAction(array $args = []);

    /**
     * Get an instance of the model for a record.
     *
     * @param array $args
     * @return Model
     */
    abstract public function getModel(array $args);
}