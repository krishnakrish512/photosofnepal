<?php
/**
 * Created by PhpStorm.
 * User: laxman
 * Date: 2/22/19
 * Time: 2:13 PM
 */

namespace NextGenImage;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ImageManager
{
    protected $imageManager;
    protected $saveFolder;
    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    //const EVENT_IMAGE_NOT_FOUND = 'image_not_found';
    //const EVENT_IMAGE_COULD_NOT_RESIZE = 'image_could_not_resize';
    //const EVENT_IMAGE_SOURCE_INVALID = 'image_source_invalid';
    const EVENT_ERROR = 'error';

    const RESIZE_METHOD_FIT = 'fit';
    const RESIZE_METHOD_NORMAL = 'resize';

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        //$this->saveFolder = ABSPATH.'cache/';
        $this->saveFolder = self::getCacheFolder();
        if(!file_exists($this->saveFolder) || !is_dir($this->saveFolder)){
            mkdir($this->saveFolder, 0755);
        }
        $this->imageManager = new \Intervention\Image\ImageManager(['driver' => 'gd']);
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getCacheFolder()
    {
        return ABSPATH.'cache/';
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function getManager()
    {
        return $this->imageManager;
    }

    public static function getInstance(EventDispatcherInterface $eventDispatcher)
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self($eventDispatcher);
        }
        return $inst;
    }

    public function resize($imagePath, $format = "webp", $size = [], $resizeMode = self::RESIZE_METHOD_FIT)
    {
        if(!file_exists($imagePath)){
            //trigger_error('Source image not found '.$imagePath, E_USER_WARNING);
            $this->eventDispatcher->dispatch(self::EVENT_ERROR, new GenericEvent(
                sprintf("Image not found: %s", $imagePath)
            ));
            return '';
        }

        $hashID = ($size) ?
            md5($imagePath.filemtime($imagePath).$resizeMode.join("-", $size)) :
            md5($imagePath.filemtime($imagePath).$resizeMode);
        $hashID .= "-v11.{$format}";
        //$hashID .= '-v'.rand().'.webp';


        if(!file_exists($this->saveFolder.$hashID)){
            try{
                //increase memory
                ini_set('memory_limit','512M');

                $imageResized = $this->imageManager->make($imagePath);
                if($size) {
                    if($resizeMode == self::RESIZE_METHOD_NORMAL){
                        $imageResized->resize($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        $imageResized->fit($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                    /*
                    if($fitImage){
                        $imageResized->fit($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        $imageResized->resize($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    */

                }
                $imageResized->save($this->saveFolder.$hashID, 75);
            }catch (\Exception $error){
                $this->eventDispatcher->dispatch(self::EVENT_ERROR, new GenericEvent(
                    $error->getMessage()
                ));
                //trigger_error($error->getMessage(), E_USER_WARNING);
                return '';
            }
        }
        return site_url('cache').'/'.$hashID;
    }

    private function getWebPImage($imagePath, $size = [], $resizeMode = self::RESIZE_METHOD_FIT)
    {
        return $this->resize($imagePath, "webp", $size , $resizeMode);
        /*
        if(!file_exists($imagePath)){
            //trigger_error('Source image not found '.$imagePath, E_USER_WARNING);
            $this->eventDispatcher->dispatch(self::EVENT_ERROR, new GenericEvent(
                sprintf("Image not found: %s", $imagePath)
            ));
            return '';
        }

        $hashID = ($size) ?
            md5($imagePath.filemtime($imagePath).$resizeMode.join("-", $size)) :
            md5($imagePath.filemtime($imagePath).$resizeMode);
        $hashID .= '-v11.webp';
        //$hashID .= '-v'.rand().'.webp';


        if(!file_exists($this->saveFolder.$hashID)){
            try{
                //increase memory
                ini_set('memory_limit','512M');

                $imageResized = $this->imageManager->make($imagePath);
                if($size) {
                    if($resizeMode == self::RESIZE_METHOD_NORMAL){
                        $imageResized->resize($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }else{
                        $imageResized->fit($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }

                }
                $imageResized->save($this->saveFolder.$hashID, 75);
            }catch (\Exception $error){
                $this->eventDispatcher->dispatch(self::EVENT_ERROR, new GenericEvent(
                    $error->getMessage()
                ));
                //trigger_error($error->getMessage(), E_USER_WARNING);
                return '';
            }
        }
        return site_url('cache').'/'.$hashID;
        */
    }
}
