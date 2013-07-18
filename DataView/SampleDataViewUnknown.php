<?php

namespace Samson\Bundle\DataViewBundle\DataView;

class SampleDataViewUnknown extends AbstractDataView
{
    public function serialize($data, array $options = array())
    {
        $this->add('propertyZ', $data);
    }

}