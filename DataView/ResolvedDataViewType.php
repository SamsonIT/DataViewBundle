<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ResolvedFormType;

class ResolvedDataViewType extends ResolvedFormType
{
    protected function newView(FormView $parent = null)
    {
        return new DataViewView($parent);
    }
}
