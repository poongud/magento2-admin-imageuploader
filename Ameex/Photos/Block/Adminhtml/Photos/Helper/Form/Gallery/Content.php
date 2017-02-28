<?php
namespace Ameex\Photos\Block\Adminhtml\Photos\Helper\Form\Gallery;

use Magento\Backend\Block\Media\Uploader;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\App\Filesystem\DirectoryList;

class Content extends \Magento\Backend\Block\Widget
{

    protected $_template = 'photos/helper/gallery.phtml';

    protected $_jsonEncoder;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        array $data = []
    ) {
        $this->_jsonEncoder = $jsonEncoder;
        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        $this->addChild('uploader', 'Magento\Backend\Block\Media\Uploader');
        //  catalog/product_gallery/upload

        // Here you can change the "ameex/photos_gallery/upload" URl upload tmp folder.
        $this->getUploader()->getConfig()->setUrl(
            $this->_urlBuilder->addSessionParam()->getUrl('ameex/photos_gallery/upload')
        )->setFileField(
            'image'
        )->setFilters(
            [
                'images' => [
                    'label' => __('Images (.gif, .jpg, .png)'),
                    'files' => ['*.gif', '*.jpg', '*.jpeg', '*.png'],
                ],
            ]
        );
        return parent::_prepareLayout();
    }

    public function getUploader()
    {
        return $this->getChildBlock('uploader');
    }

    public function getUploaderHtml()
    {
        return $this->getChildHtml('uploader');
    }

    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'JsObject';
    }

    public function getAddImagesButton()
    {
        return $this->getButtonHtml(
            __('Add New Images'),
            $this->getJsObjectName() . '.showUploader()',
            'add',
            $this->getHtmlId() . '_add_images_button'
        );
    }

    public function getImagesArray(){
        // This methods get the image list from the image module- Your optional
        $images = array( );
        return $images;
    }

    //  This methods pass the exists images to display 
    //  Return Json data.
    public function getImagesJson()
    {

        $ImageArray = $this->getImagesArray();
            // For testing sample images array data 
            $customImage  = array( 
                array('value_id'=> '1',
                'file' => '/m/b/mb01-blue-0.jpg',
                'media_type' => 'image',
                'entity_id' => '',
                'label' => 'Image',
                'position' => 1,
                'disabled' => 0,
                'url' => 'http://10.10.4.238/mage21/pub/media/catalog/product/m/b/mb01-blue-0.jpg',
                'size' => 246955,
                'image_description' => 'Hello world',
                'image_alt' => 'a tag alert show here'
                )
            );
        if (is_array($ImageArray) && count($ImageArray)) {
            //$directory = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
            //$image['url'] = $this->_mediaConfig->getMediaUrl($image['file']);
            $images = $this->sortImagesByPosition($ImageArray);
            foreach ($images as &$image) {
                // code is for image model - image data of array - Perpare like above sample array.
            }
            return $this->_jsonEncoder->encode($customImage);
        }
        return $this->_jsonEncoder->encode($customImage);
    }

    private function sortImagesByPosition($images)
    {
        if (is_array($images)) {
            usort($images, function ($imageA, $imageB) {
                return ($imageA['position'] < $imageB['position']) ? -1 : 1;
            });
        }
        return $images;
    }
}
