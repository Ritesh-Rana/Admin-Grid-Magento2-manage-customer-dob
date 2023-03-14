<?php

namespace Sigma\Form\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
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
        $resultPage->getConfig()->getTitle()->prepend(__('Sigma Form'));
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
            'sigma_form',
            [
                'label' => __('Sigma Form'),
                'title' => __('Sigma Form')
            ]
        );
        $resultPage->addHandle('sigma_form_index_index');
        return $resultPage;
    }
}
