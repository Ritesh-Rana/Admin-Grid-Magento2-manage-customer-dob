<?php

namespace Sigma\Form\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\ResourceConnection;

class SaveForm extends Action
{
    protected $resultPageFactory;
    protected $filesystem;
    protected $resourceConnection;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Filesystem $filesystem,
        ResourceConnection $resourceConnection
    ) {
        parent::__construct($context);
        $this->filesystem = $filesystem;
        $this->resultPageFactory = $resultPageFactory;
        $this->resourceConnection=$resourceConnection;
    }

    public function execute()
    {
        $mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $targetDir = $mediaDirectory->getAbsolutePath();
        
        $postData = $this->getRequest()->getParams();
        var_dump($postData);
        if(!is_dir($targetDir .'sigma_form_upload/'))
            mkdir($targetDir .'sigma_form_upload/');
        if ($postData) {
           $upgradeData=array();
            $activity = implode(',', $postData['activities']);

            $upgradeData['first_name']=$postData['first_name'];
            $upgradeData['last_name']=$postData['last_name'];
            $upgradeData['email']=$postData['email'];
            $upgradeData['birthdate']=$postData['birthdate'];
            $upgradeData['activities']=$activity;
            $filename = date('y-m-d h:m:s');
            $upgradeData['file_upload']=$filename;
            
            $targetFilename = $targetDir .'sigma_form_upload/'. $filename ;

            move_uploaded_file($_FILES['file']['tmp_name'], $targetFilename);
            
            
            $connection = $this->resourceConnection->getConnection();
            $table = $this->resourceConnection->getTableName('sigma_form');
            if(array_key_exists('update',$postData)){
                if($postData['update']==1)
                $connection->update($table, $upgradeData,'entity_id='.$postData['id']);
            }
            else
                $connection->insert($table, $upgradeData);
            
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('sigma_form/tabledata/formdata');
            return $resultRedirect;
        }
    }
}
