<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntityType extends AbstractType
{
    public function getName()
    {
        return 'entity';
    }

    public function getParent()
    {
        return 'form';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $idProperty    = $options['id_property'];
        $labelProperty = $options['label_property'];

        $builder->add('id', 'id', array('id_fields' => (array) $idProperty, 'class' => $options['data_class']));

        if ($labelProperty) {
            $builder->add($labelProperty, 'text');
        } else {
            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $e) {
                $e->getForm()->add('name', 'text', array('mapped' => false, 'data' => (string) $e->getData()));
            });
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'id_property'    => 'id',
            'label_property' => null
        ));
    }
}
