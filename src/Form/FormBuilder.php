<?php

namespace Administr\Form;

use Closure;
use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;

class FormBuilder
{
    /**
     * @var array
     */
    private $fields = [];

    /**
     * Shortcut for easier definition of forms.
     *
     * @param Closure $definition
     * @return $this
     */
    public function define(Closure $definition)
    {
        $definition($this);

        return $this;
    }

    /**
     * Add a field to the form.
     *
     * @param AbstractType $field
     */
    public function add(AbstractType $field)
    {
        $this->fields[] = $field;
    }

    /**
     * Add a text field.
     *
     * @param $fieldName
     * @param $fieldLabel
     * @param array $options
     */
    public function text($fieldName, $fieldLabel, $options = [])
    {
        $this->add(new Text($fieldName, $fieldLabel, $options));
    }

    /**
     * Basic rendering of the form.
     *
     * @return string
     */
    public function render()
    {
        $form = '';

        foreach($this->fields as $field)
        {
            $form .= $field->render();
        }

        return $form;
    }

    /**
     * Get the fields in the form.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }
}