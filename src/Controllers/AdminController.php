<?php

namespace Administr\Controllers;

use Administr\Form\Form;
use Administr\ListView\ListView;
use Illuminate\Contracts\View\View;
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

    /**
     * @param string|array $title
     * @param string $separator
     */
    protected function title($title, $separator = ' - ')
    {
        if(is_array($title)) {
            $title = implode($separator, $title);
        }

        view()->composer(['administr::layout.master', 'administr::layout.auth'], function(View $view) use ($title) {
            $view->with('pageTitle', $title);
        });
    }

    /**
     * Show a model, if applicable.
     *
     * @param $id
     * @param string $redirectTo
     * @param string $visibleField
     * @return Response
     */
    public function showItem($id, $redirectTo = null, $visibleField = 'is_visible')
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
    public function hideItem($id, $redirectTo = null, $visibleField = 'is_visible')
    {
        $model = $this->getModel([$id]);

        $model->update([$visibleField => false]);

        if($redirectTo) {
            return redirect($redirectTo);
        }

        return back();
    }

    /**
     * Save a translated model.
     *
     * @param Form $form
     * @param Model $model
     * @return bool
     */
    protected function saveTranslations(Form $form, Model $model)
    {
        foreach($form->translated() as $language_id => $translation)
        {
            $model
                ->language($language_id)
                ->fill($translation);
        }

        return $model->save();
    }

    protected function getForm()
    {
        if($this->form instanceof Form) {
            return $this->form;
        }

        if(is_null($this->form)) {
            $this->form = $this->getFormClass();
        }

        $this->form = app($this->form);

        return $this->form;
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
}