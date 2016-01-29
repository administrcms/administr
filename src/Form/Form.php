<?php

namespace Administr\Form;

abstract class Form
{
    protected $form;
    protected $rules;

    public function __construct(FormBuilder $form)
    {
        $this->form = $form;
    }

    /**
     * Render the form HTML.
     *
     */
    public function render()
    {
    }

    /**
     * Define the validation rules for the form.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * Define the fields of the form
     *
     * @return
     */
    abstract public function form();
}