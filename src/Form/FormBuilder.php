<?php

namespace Administr\Form;

use Closure;
use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;

class FormBuilder
{
    private $fields = [];

    public function define(Closure $definition)
    {
        $definition($this);

        return $this;
    }

    public function add(AbstractType $field)
    {
        $this->fields[] = $field;
    }

    {
        $this->add(new Text($fieldName, $fieldLabel, $options));
    }

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