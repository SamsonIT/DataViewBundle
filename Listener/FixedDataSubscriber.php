<?php

namespace Samson\Bundle\DataViewBundle\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class FixedDataSubscriber implements EventSubscriberInterface
{
    private $fixedValues = array();

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData'
        );
    }

    public function add($name, $type, $callable)
    {
        $this->fixedValues[$name] = array($type, $callable);
    }

    public function preSetData(FormEvent $e)
    {
        foreach ($this->fixedValues as $name => $data) {
            $callable = $data[1];
            $e->getForm()->add($name, $data[0], array('mapped' => false, 'data' => $callable($e->getData())));
        }
    }
}

 