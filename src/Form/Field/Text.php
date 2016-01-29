<?php

namespace Administr\Form\Field;


class Text extends AbstractType
{
    public function renderField()
    {
        $attrs = array_merge([
            'id'    => $this->name,
            'name'  => $this->name,
            'type'  => 'text'
        ], $this->options);

        return '<input' . $this->renderAttributes($attrs) . '>';
    }

    public function renderLabel()
    {
        // TODO: Implement renderLabel() method.
    }

    public function renderErrors()
    {
        // TODO: Implement renderErrors() method.
    }
}