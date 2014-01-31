<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SimpleType extends AbstractType
{
    public function getName()
    {
        return 'simple';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * The form component will cast all values to string unless there's a view transformer, so we added one that
         * doesn't actually do anything
         */
        $builder->addViewTransformer(new CallbackTransformer(function ($value) {
            return $value;
        }, function ($value) {
            return $value;
        }));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('compound' => false));
    }
}
