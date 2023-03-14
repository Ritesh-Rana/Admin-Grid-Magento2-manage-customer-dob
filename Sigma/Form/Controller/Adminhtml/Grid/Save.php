<?php

namespace Sigma\Form\Controller\Adminhtml\Grid;

use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var \Sigma\Form\Model\GridFactory
     */
    var $gridFactory;
    protected $filesystem;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Sigma\Form\Model\GridFactory $gridFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Sigma\Form\Model\GridFactory $gridFactory,
        Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->filesystem = $filesystem;

        $this->gridFactory = $gridFactory;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setEntityId($data['id']);
            }
            
            $file=$_FILES['file_upload'];
           
            $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
            $targetDir = $mediaDirectory->getAbsolutePath();

            if(!is_dir($targetDir .'sigma_form_upload/'))
                mkdir($targetDir .'sigma_form_upload/');
                
            $filename = date('y-m-d h:m:s');
            $rowData['file_upload']=(string)date('y-m-d h:m:s');
            $targetFilename = $targetDir .'sigma_form_upload/'. $filename ;

            move_uploaded_file($_FILES['file_upload']['tmp_name'], $targetFilename);
            
            $rowData['activities']=implode(',',$rowData['activities']);
            $rowData->save();
            $this->messageManager->addSuccess(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__('Kuch toh gadbad hai bawa .......'));
            $this->messageManager->addError(__($e->getMessage()));
        }
        $this->_redirect('grid/grid/index');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sigma_Form::save');
    }
}
