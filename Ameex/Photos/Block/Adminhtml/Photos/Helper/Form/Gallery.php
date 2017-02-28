<?php
namespace Ameex\Photos\Block\Adminhtml\Photos\Helper\Form;

use Magento\Framework\Registry;

class Gallery extends \Magento\Framework\View\Element\AbstractBlock
{

    protected $fieldNameSuffix = 'ameex';

    protected $htmlId = 'media_gallery';

    protected $name = 'photo[media_gallery]';

    protected $image = 'image';

    protected $formName = 'photo_form';

    protected $storeManager;

    protected $form;

    protected $registry;

    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Registry $registry,
        \Magento\Framework\Data\Form $form,
        $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->registry = $registry;
        $this->form = $form;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        $this->addChild('content_items','Ameex\Photos\Block\Adminhtml\Photos\Helper\Form\Gallery\Content');
        return parent::_prepareLayout();
    }

    public function getElementHtml()
    {
        $html = $this->getContentHtml();
        return $html;
    }

    public function getImages()
    {
        return $this->registry->registry('current_seller')->getData('media_gallery') ?: null;
    }

    public function getContentHtml()
    {
        /* @var $content \Ameex\Photos\Block\Adminhtml\Photos\Helper\Form\Gallery\Content */
        $content = $this->getChildBlock('content_items'); 

        $content->setId($this->getHtmlId() . '_content')->setElement($this);
        $content->setFormName($this->formName);
        $galleryJs = $content->getJsObjectName();
        $content->getUploader()->getConfig()->setMegiaGallery($galleryJs);
        return $content->toHtml(); 
    }

    protected function getHtmlId()
    {
        return $this->htmlId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFieldNameSuffix()
    {
        return $this->fieldNameSuffix;
    }

    public function getDataScopeHtmlId()
    {
        return $this->image;
    }

    public function getDataObject()
    {
        return $this->registry->registry('current_seller');
    }

    public function toHtml()
    {
        return $this->getElementHtml();
    }
}
