<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Form\ButtonBuilder;
use Symfony\Component\Form\ButtonTypeInterface;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ResolvedFormType;
use Symfony\Component\Form\SubmitButtonBuilder;
use Symfony\Component\Form\SubmitButtonTypeInterface;

class ResolvedDataViewType extends ResolvedFormType
{
    protected function newView(FormView $parent = null)
    {
        return new DataViewView($parent);
    }

    protected function newBuilder($name, $dataClass, FormFactoryInterface $factory, array $options)
    {
        return new DataViewBuilder($name, $dataClass, new EventDispatcher(), $factory, $options);
    }
}
