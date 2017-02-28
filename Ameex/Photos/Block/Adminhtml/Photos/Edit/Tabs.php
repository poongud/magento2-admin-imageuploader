<?php

namespace Ameex\Photos\Block\Adminhtml\Photos\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('photos_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Photos'));
    }

    protected function _beforeToHtml()
    {

        $this->addTab(
            'photos_info',
            [
                'label' => __('General'),
                'title' => __('General'),
                'content' => $this->getLayout()->createBlock(
                    'Ameex\Photos\Block\Adminhtml\Photos\Edit\Tab\Info'
                )->toHtml(),
                'active' => true
            ]
        );
	// CODE FOR AMEEX PHOTOS //
	// ADDING IMAGES TAB IN EDIT PAGE
	// This method to call the image block to our edit form.
        $this->addTab(
            'photo_images',
            [
                'label' => __('Ameex photos'),
                'title' => __('Ameex photos'),
                'content' => $this->getLayout()->createBlock(
                    'Ameex\Photos\Block\Adminhtml\Photos\Helper\Form\Gallery'
                )->toHtml()
            ]
        );
 
        return parent::_beforeToHtml();
    }
}
