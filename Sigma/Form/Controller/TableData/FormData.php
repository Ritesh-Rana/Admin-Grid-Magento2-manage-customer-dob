<?php

namespace Sigma\Form\Controller\TableData;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class FormData extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('SQL Table'));
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
            'Form Data',
            [
                'label' => __('Form Data'),
                'title' => __('Go to Form Data Page')
            ]
        );

        $collection = $this->_objectManager->create('Sigma\Form\Model\ResourceModel\Grid\Collection');
        $resultPage->getLayout()->getBlock('sigma_form')->setCollection($collection);
        return $resultPage;
    }
}
