<?php

namespace Samson\Bundle\DataViewBundle\Type;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IdType extends AbstractType
{
    private $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getName()
    {
        return 'id';
    }

    public function getParent()
    {
        return 'form';
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (count($options['id_fields']) > 1) {
            foreach ($options['id_fields'] as $idField) {
                $builder->add($idField, 'integer');
            }
        } else {
            $builder->addViewTransformer(new CallbackTransformer(function ($value) {
                return null === $value ? null : (int) $value;
            }, function ($value) {
                return $value;
            }));
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'em'            => null,
            'compound'      => function (Options $options) {
                return count($options['id_fields']) > 1;
            },
            'id_fields'     => function (Options $options) {
                $em = $options['em'];
                /** @var $clm ClassMetadata */
                $clm = $em->getClassMetadata($options['class']);

                return $clm->getIdentifierFieldNames();
            },
            'property_path' => function (Options $options) {
                if (count($options['id_fields']) == 1) {
                    return $options['id_fields'][0];
                }

                throw new \LogicException('Not implemented...');
            }
        ));
        $resolver->setRequired(array('class'));

        $registry = $this->doctrine;

        $resolver->setNormalizers(array('em' => function (Options $options, $em) use ($registry) {
            /* @var ManagerRegistry $registry */
            if (null !== $em) {
                return $registry->getManager($em);
            }

            $em = $registry->getManagerForClass($options['class']);

            if (null === $em) {
                throw new RuntimeException(sprintf(
                    'Class "%s" seems not to be a managed Doctrine entity. ' .
                    'Did you forget to map it?',
                    $options['class']
                ));
            }

            return $em;
        }));
    }
}
