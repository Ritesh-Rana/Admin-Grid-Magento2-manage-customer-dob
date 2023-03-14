<?php

namespace Sigma\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\FormFactory;

class Form extends Template
{
    protected $formFactory;

    public function __construct(
        Template\Context $context,
        FormFactory $formFactory,
        \Sigma\Form\Model\Status $options,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->formFactory = $formFactory;
        $this->_options = $options;

    }
    public function getFormHtml()
{
    $id=$this->getRequest()->getParam('id');
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

    $model = $objectManager->create('Sigma\Form\Model\Grid');
    $formdata=$model->load($id)->getData();
    $email=$formdata['email'];
    $firstname=$formdata['first_name'];
    $lastname=$formdata['last_name'];
    $birthdate=$formdata['birthdate'];
    $activities=explode(',',$formdata['activities']);
    $form = $this->formFactory->create();

    $form->setAction($this->getUrl('sigma_form/index/saveform'));
    $form->setMethod('post');
    $form->setEnctype('multipart/form-data');
    $form->setUseContainer(true);

    $fieldset = $form->addFieldset('my_fieldset', [
        'legend'=>__("Edit Forms")
    ]);

    $fieldset->addField(
        'email',
        'text',
        [
            'name' => 'email',
            'label' => __('Email'),
            'id' => 'email',
            'title' => __('Email'),
            'class' => 'required-entry',
            'required' => true,
            'value'=>$email
        ]
    );


    $fieldset->addField(
        'first_name',
        'text',
        [
            'name' => 'first_name',
            'label' => __('first_name'),
            'id' => 'first_name',
            'title' => __('first_name'),
            'class' => 'required-entry',
            'required' => true,
            'value'=>$firstname
        ]
    );
    $fieldset->addField(
        'last_name',
        'text',
        [
            'name' => 'last_name',
            'label' => __('last_name'),
            'id' => 'last_name',
            'title' => __('last_name'),
            'class' => 'required-entry',
            'required' => true,
            'value'=>$lastname
            
        ]
    );
    $fieldset->addField(
        'birthdate',
        'text',
        [
            'name' => 'birthdate',
            'label' => __('birthdate'),
            'id' => 'birthdate',
            'title' => __('birthdate'),
            'class' => 'required-entry',
            'required' => true,
            'value'=>$birthdate
        ]
    );
    $fieldset->addField(
        'activities',
        'multiselect',
        [
            'name' => 'activities[]',
            'label' => __('activities'),
            'title' => __('activities'),
            'values' => $this->_options->toOptionArray(),
            'value'=>$activities

        ]
    );
    $fieldset->addField(
        'file_upload',
        'file',
        [
            'label' => __('file_upload'),
            'title' => __('file_upload'),
            'name' => 'file',
            'required' => false,
            'uploader' => true,
            'max_file_size' => '2097152', // Maximum file size in bytes (optional)
        ]
    );
    $fieldset->addField(
        'update',
        'hidden',
        [
            'name' => 'update',
            'label' => __('update'),
            'id' => 'update',
            'title' => __('update'),
            'value'=>true,
        ]
    );
    $fieldset->addField(
        'id',
        'hidden',
        [
            'name' => 'id',
            'label' => __('id'),
            'id' => 'id',
            'title' => __('id'),
            'value'=>$id,
        ]
    );
    $fieldset->addField('submit', 'submit', [
        'value' => __('Submit')
    ]);

    return $form->toHtml();
}
public function toHtml()
{
    return $this->getFormHtml();
}

}
