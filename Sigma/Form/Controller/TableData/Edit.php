<?php

namespace Sigma\Form\Controller\TableData;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action{

    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Edit '));
        $breadcrumbs = $resultPage->getLayout()->getBlock('breadcrumbs');

        $breadcrumbs->addCrumb(
            'home',
            [
                'label' => __('Home'),
                'title' => __('Go to Home Page'),
                'link' => $this->_url->getUrl('')
            ]
        );
        $breadcrumbs->addCrumb(
            'My Account',
            [
                'label' => __('My Account'),
                'title' => __('Go to My Account Page')
            ]
        );
        $breadcrumbs->addCrumb(
            'Edit Data',
            [
                'label' => __('Edit Data'),
                'title' => __('Go to Edit Page')
            ]
        );
        
        $collection = $this->_objectManager->create('Sigma\Form\Model\ResourceModel\Grid\Collection');
        return $resultPage;
    }
}