<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Samson\Bundle\DataViewBundle\DataView\AbstractDataView;
use Samson\Bundle\DataViewBundle\DataView\SampleDataView;

class SampleMergePrefixedView extends AbstractDataView
{

    public function serialize($data, array $options = array())
    {
        $this->add(new SampleDataView, $data->getNestedEntity(), 'nested', array('merge' => true, 'prefix' => $options['prefix']));
        $this->add('propertyD', $data);
        $this->add('propertyE', $data);
        $this->add('propertyF', $data);

    }


}