<?php

namespace Samson\Bundle\DataViewBundle\DataView;

class SampleDataViewAdvanced extends AbstractDataView
{
    public function serialize($data, array $options = array())
    {
        $this->add('propertyA', $data);
        $this->add(new SampleDataView, $data->getNestedEntity(), "nested");
    }

}