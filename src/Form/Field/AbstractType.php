<?php

namespace Administr\Form\Field;


abstract class AbstractType
{
    protected $name;
    protected $options = [];
    protected $rules = [];

    public function __construct($name, $options = [], $rules = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->rules = $rules;
    }

    public function renderAttributes(array $attrs)
    {
        if(count($attrs) === 0)
        {
            return '';
        }

        $attributes = "";
        foreach ($attrs as $attr => $value) {
            $attributes .= " {$attr}=\"{$value}\"";
        }

        return $attributes;
    }

    public function render()
    {
        return $this->renderLabel() . $this->renderField() . $this->renderErrors();
    }

    abstract public function renderField();
    abstract public function renderLabel();
    abstract public function renderErrors();
}