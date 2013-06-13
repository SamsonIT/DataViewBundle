<?php

namespace Samson\Bundle\DataViewBundle\DataView;

class SampleDataViewOptions extends AbstractDataView
{
    public function serialize($data, array $options = array())
    {
        $this->add('propertyA', $data);
        if ($this->get($options, 'showB')) {
            $this->add('propertyB', $data);
        }
    }

}