<?php

namespace Sigma\Form\Block\Adminhtml\Grid\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    protected $_systemStore;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
        \Sigma\Form\Model\Status $options,
        array $data = []
    ) {
        
        $this->_options = $options;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareForm()
    {
        $dateFormat = $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT);
        $model = $this->_coreRegistry->registry('row_data');
        $form = $this->_formFactory->create(
            ['data' => [
                            'id' => 'edit_form',
                            'enctype' => 'multipart/form-data',
                            'action' => $this->getData('action'),
                            'method' => 'post'
                        ]
            ]
        );

        $form->setHtmlIdPrefix('wkgrid_');
        if ($model->getEntityId()) {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Edit Row Data'), 'class' => 'fieldset-wide']
            );
            $fieldset->addField('entity_id', 'hidden', ['name' => 'entity_id']);
        } else {
            $fieldset = $form->addFieldset(
                'base_fieldset',
                ['legend' => __('Add Row Data'), 'class' => 'fieldset-wide']
            );
        }

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
            ]
        );

        $wysiwygConfig = $this->_wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

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
            ]
        );
        $fieldset->addField(
            'file_upload',
            'file',
            [
                'label' => __('file_upload'),
                'title' => __('file_upload'),
                'name' => 'file_upload',
                'required' => false,
                'uploader' => true,
                'max_file_size' => '2097152', // Maximum file size in bytes (optional)
            ]
        );
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/fffffffff.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info(print_r($model->getData()));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
