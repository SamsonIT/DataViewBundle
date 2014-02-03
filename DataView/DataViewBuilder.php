<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Samson\Bundle\DataViewBundle\Listener\FixedDataSubscriber;
use Symfony\Component\Form\FormBuilder;

class DataViewBuilder extends FormBuilder
{
    private $fixedDataSubscriber;

    protected function getFixedDataSubscriber()
    {
        if (null === $this->fixedDataSubscriber) {
            $this->fixedDataSubscriber = new FixedDataSubscriber();
            $this->addEventSubscriber($this->fixedDataSubscriber);
        }

        return $this->fixedDataSubscriber;
    }

    public function addFixed($name, $type, $callable)
    {
        $this->getFixedDataSubscriber()->add($name, $type, $callable);
        return $this;
    }
}
