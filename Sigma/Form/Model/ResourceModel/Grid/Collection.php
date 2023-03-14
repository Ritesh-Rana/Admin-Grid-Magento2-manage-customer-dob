<?php

namespace Sigma\Form\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'Sigma\Form\Model\Grid',
            'Sigma\Form\Model\ResourceModel\Grid'
        );
    }
}
