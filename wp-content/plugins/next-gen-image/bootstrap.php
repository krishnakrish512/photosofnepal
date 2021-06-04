<?php
/**
 * Created by PhpStorm.
 * User: laxman
 * Date: 2/22/19
 * Time: 2:18 PM
 */

namespace NextGenImage;


use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/admin.php';

function resizeImage($imagePath, $format = "webp", $size = [], $resizeMode = ImageManager::RESIZE_METHOD_FIT)
{
    //var_dump($imagePath);
    //$imagePath = "/Users/laxman/www-procab/comptoir/wp-content/uploads/2018/11/23018_aphoto1436286-asdf.jpg";
    $resizer = ImageManager::getInstance(new EventDispatcher());

    $dateFormat = "Y n j, g:i a";
    // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
    $output = "%datetime% > %level_name% > %message% %context% %extra%\n";

    // finally, create a formatter
    $formatter = new LineFormatter($output, $dateFormat);
    $stream = new StreamHandler(__DIR__.'/logs', Logger::DEBUG);
    $stream->setFormatter($formatter);

    $logger = new Logger('next-gen-image-resizer');
    $logger->pushHandler($stream);

    $resizer->getEventDispatcher()->addListener(ImageManager::EVENT_ERROR, function(GenericEvent $event) use ($logger){
        //var_dump("Error: ".$event->getSubject());
        $logger->addError($event->getSubject());
    });
    return $resizer->resize($imagePath, $format, $size, $resizeMode);
}

function getImageInWebp(string $imagePath, array $size = [], $resizeMode = ImageManager::RESIZE_METHOD_FIT){
    return resizeImage($imagePath, "webp", $size, $resizeMode);
}

function getWebPHTML($webPFormatUrl, $fallbackImageUrl, $imageAttributes = [])
{
    //$webPFormatUrl = $fallbackImageUrl;
    //$imageAttributeHtml = ($imageAttributeHtml) ? join(" ", $imageAttributeHtml) : '';
    $imageAttributeHtml = [];
    foreach ($imageAttributes as $key=>$imageAttribute){
        $imageAttributeHtml[] = "{$key} = '{$imageAttribute}'";
    }
    $imageAttributeHtml = join(" ", $imageAttributeHtml);
    $html = <<<EOF
     <picture>
                      <source srcset="{$webPFormatUrl}" type="image/webp" {$imageAttributeHtml} >
                      <source srcset="{$fallbackImageUrl}" type="image/jpeg" {$imageAttributeHtml} > 
                      <img data-webp-enabled  src="{$fallbackImageUrl}" {$imageAttributeHtml} >
    </picture>
EOF;
    return $html;
}


//add_filter

/*
add_filter('wp_get_attachment_image_src', function($image){
    $webpResizer = NextGenImages::getInstance(ABSPATH.'cache/uploads/');
    $image[0] = site_url('cache/uploads/').$webpResizer->getWebPImage($image[0], [$image[1], $image[2]]);
    return $image;
});
*/

add_filter('the_content', function($content){
    /*
    $webpResizer = NextGenImages::getInstance(ABSPATH.'cache/uploads/');
    $image[0] = site_url('cache/uploads/').$webpResizer->getWebPImage($image[0], [$image[1], $image[2]]);
    return $image;
    */
    return wp_make_content_images_responsivex($content);
}, 99, 1);


function wp_make_content_images_responsivex( $content ) {
    if ( ! preg_match_all( '/<img [^>]+>/', $content, $matches ) ) {
        return $content;
    }

    $selected_images = $attachment_ids = array();



    foreach( $matches[0] as $image ) {
        if (false === strpos($image,"data-webp-enabled") &&
            false === strpos( $image, ' srcset=' ) && preg_match( '/wp-image-([0-9]+)/i', $image, $class_id ) &&
            ( $attachment_id = absint( $class_id[1] ) ) ) {

            //var_dump($image, $class_id);

            //get css classes
            $imageAttrs = [];
            preg_match( '/class="[a-zA-Z0-9-_ ]+"/', $image, $imageCss );
            preg_match( '/title="[a-zA-Z0-9-_ ]+"/', $image, $imageTitle );
            preg_match( '/alt="[a-zA-Z0-9-_ ]+"/', $image, $imageAltTitle );
            preg_match( '/width="[0-9]+"/', $image, $imageAttrWidth );
            preg_match( '/height="[0-9]+"/', $image, $imageAttrHeight );

            if($imageCss) $imageAttrs[] = $imageCss[0];
            if($imageTitle) $imageAttrs[] = $imageTitle[0];
            if($imageAltTitle) $imageAttrs[] = $imageAltTitle[0];
            if($imageAttrWidth) $imageAttrs[] = $imageAttrWidth[0];
            if($imageAttrHeight) $imageAttrs[] = $imageAttrHeight[0];

            /*
             * If exactly the same image tag is used more than once, overwrite it.
             * All identical tags will be replaced later with 'str_replace()'.
             */
            $selected_images[ $image ] = ['id'=> $attachment_id, 'attr' => $imageAttrs];



            // Overwrite the ID when the same image is included more than once.
            $attachment_ids[ $attachment_id ] = true;
        }
    }


    if ( count( $attachment_ids ) > 1 ) {
        /*
         * Warm the object cache with post and meta information for all found
         * images to avoid making individual database calls.
         */
        _prime_post_caches( array_keys( $attachment_ids ), false, true );
    }

    //var_dump($image);
    foreach ( $selected_images as $image => $selected_image ) {
        $attachment_id = $selected_image['id'];
        $image_meta = wp_get_attachment_metadata( $attachment_id );

        //var_dump($image_meta);
        $currentImageMeta = [];
        foreach ($image_meta['sizes'] as $imageMetaItem){
            if(strpos($image, $imageMetaItem['file'])){
                $currentImageMeta = $imageMetaItem;
                break;
            }
        }

        //create size
        $imagePath = wp_upload_dir()['basedir'] ."/".$image_meta['file'];

        if($currentImageMeta){
            $imageWp = getImageInWebp($imagePath, [$currentImageMeta['width'],$currentImageMeta['height']]);
        }else{
            $imageWp = getImageInWebp($imagePath);
        }


        $fallbackImagePath = wp_upload_dir()['baseurl']."/".$image_meta['file'];

        $imageHtml = getWebPHTML($imageWp, $fallbackImagePath);

        //add attributes
        $imageAttributeHtml = join(" ", $selected_image['attr']);
        $imageHtml = str_replace("<img", "<img {$imageAttributeHtml}", $imageHtml);

        $content = str_replace( $image, $imageHtml, $content );
        //$content = str_replace( $image, wp_image_add_srcset_and_sizes( $image, $image_meta, $attachment_id ), $content );
    }

    return $content;
}