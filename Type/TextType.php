<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;

class TextType extends AbstractType
{
    public function getName()
    {
        return 'text';
    }

    public function getParent()
    {
        return 'simple';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new CallbackTransformer(function ($value) {
            return null === $value ? null : (string) $value;
        }, function ($value) {
            return $value;
        }));
    }
}
