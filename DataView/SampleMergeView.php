<?php

namespace Samson\Bundle\DataViewBundle\DataView;

use Samson\Bundle\DataViewBundle\DataView\AbstractDataView;
use Samson\Bundle\DataViewBundle\DataView\SampleDataView;

class SampleMergeView extends AbstractDataView
{

    public function serialize($data, array $options = array())
    {
        $this->add(new SampleDataView, $data->getNestedEntity(), null, array('merge' => true));
        $this->add('propertyD', $data);
        $this->add('propertyE', $data);
        $this->add('propertyF', $data);

    }


}