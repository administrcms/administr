<?php

namespace Administr\Form\Field;


class Text extends AbstractType
{
    public function renderField()
    {
        $attrs = array_merge($this->options, [
            'id'    => $this->name,
            'name'  => $this->name,
            'type'  => 'text'
        ]);

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