<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class FloatType extends AbstractType
{
    public function getName()
    {
        return 'float';
    }

    public function getParent()
    {
        return 'simple';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new CallbackTransformer(function ($value) {
            return null === $value ? null : (float) $value;
        }, function ($value) {
            return $value;
        }));
    }
}
