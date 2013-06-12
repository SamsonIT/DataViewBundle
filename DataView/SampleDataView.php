<?php

namespace Samson\Bundle\DataViewBundle\DataView;

class SampleDataView extends AbstractDataView
{
    public function serialize($data, array $options = array())
    {
        $this->add('propertyA', $data );
        $this->add('propertyB', $data);
        $this->add('propertyC', $data);
    }

}