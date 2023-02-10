<?php
/**
 * Module AdminGrid Model
 * @package Module/AdminGrid
 */
declare(strict_types=1);

namespace Module\AdminGrid\Model;

class CustomRule extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{

    const CACHE_TAG = 'customer_dob_manage';

	protected $_cacheTag = 'customer_dob_manage';

	protected $_eventPrefix = 'customer_dob_manage';

	protected function _construct()
	{
		$this->_init('Module\AdminGrid\Model\ResourceModel\CustomRule');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}
