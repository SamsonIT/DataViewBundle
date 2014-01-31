<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\Form\FormView;

class DataViewView extends FormView
{

    /**
     * This is the method that will actually fetch the data off the view object
     *
     * @return array
     */
    public function getData()
    {
        if ($this->vars['compound']) {
            return array_map(function (DataViewView $view) {
                return $view->getData();
            }, $this->children);
        }

        return $this->vars['value'];
    }
}
