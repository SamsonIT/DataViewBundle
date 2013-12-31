<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\Form\FormView;

class DataViewView extends FormView
{
    public function getData()
    {
        if ($this->vars['compound']) {
            return array_map(function (DataViewView $view) {
                return $view->getData();
            }, $this->children);
        }

        return $this->vars['data'];
    }

} 