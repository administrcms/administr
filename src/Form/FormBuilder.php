<?php

namespace Administr\Form;


use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;

class FormBuilder
{
    private $fields = [];
    private $rules = [];

    public function add(AbstractType $field)
    {
        $this->fields[] = $field;
    }

    public function text($fieldName, $options = [])
    {
        $this->add(new Text($fieldName, $options));
    }
}