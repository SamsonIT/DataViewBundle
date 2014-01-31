<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class DateType extends AbstractType
{
    public function getName()
    {
        return 'date';
    }

    public function getParent()
    {
        return 'simple';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(function ($value) {
            return null === $value ? null : $value->format('Y-m-d');
        }, function ($value) {
            return $value;
        }));
    }
}
