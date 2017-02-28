<?php

namespace Ameex\Photos\Controller\Adminhtml\Photos;

use Ameex\Photos\Controller\Adminhtml\Photo;

class Edit extends Photo
{
    public function execute()
    {
        $id = $this->getRequest()->getParam('photo_id');
        $model = $this->_objectManager->create('Ameex\Photos\Model\Photos');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                $this->_redirect('ameex/photos/index');
                return;
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getPageData(true);
        if (!empty($data)) {
            $model->addData($data);
        }
        $this->_coreRegistry->register('current_photos', $model);
        $this->_initAction()->_addBreadcrumb(
            $id ? __('Edit Post') : __('Add New Photos'),
            $id ? __('Edit Post') : __('Add New Photos')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('AmeexPhotos'));
        $this->_view->getPage()->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('Add New Photos'));        
        $this->_view->renderLayout();
    }
}
