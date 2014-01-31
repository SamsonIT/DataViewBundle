<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class IntegerType extends AbstractType
{
    public function getName()
    {
        return 'integer';
    }

    public function getParent()
    {
        return 'simple';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new CallbackTransformer(function ($value) {
            return null === $value ? null : (int) $value;
        }, function ($value) {
            return $value;
        }));
    }
}
