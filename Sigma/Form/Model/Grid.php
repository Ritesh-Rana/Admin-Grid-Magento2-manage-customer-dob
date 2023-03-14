<?php

namespace Sigma\Form\Model;

class Grid extends \Magento\Framework\Model\AbstractModel 
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'sigma_form';

    /**
     * @var string
     */
    protected $_cacheTag = 'sigma_form';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'sigma_form';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Sigma\Form\Model\ResourceModel\Grid');
    }

}