<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TimeType extends AbstractType
{
    public function getName()
    {
        return 'time';
    }

    public function getParent()
    {
        return 'simple';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $format = 'H:i' . ($options['with_seconds'] ? ':s' : '');

        $builder->addModelTransformer(new CallbackTransformer(function ($value) use ($format) {
            return null === $value ? null : $value->format($format);
        }, function ($value) {
            return $value;
        }));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array('with_seconds' => false));
    }
}
