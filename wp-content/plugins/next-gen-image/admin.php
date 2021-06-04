<?php
/**
 * Created by PhpStorm.
 * User: laxman
 * Date: 3/6/19
 * Time: 4:46 PM
 */
namespace NextGenImage;

add_action('admin_menu', function(){
    add_menu_page( 'Next Gen Image',
        'Next Gen Image',
        'manage_options',    //created custom capability for the artist role
        'next-gen-image',
        '\NextGenImage\pageHandler');

    add_submenu_page('next-gen-image', 'Show Logs',
        'Show logs',
        'manage_options',    //created custom capability for the artist role
        'next-gen-image-log',
        '\NextGenImage\logPageHandler');
});


function pageHandler(){
    $logsPath = plugin_dir_url(__FILE__);
    $message  = null;
    $service = (isset($_GET['service']) && $_GET['service']!='') ? filter_var($_GET['service'], FILTER_SANITIZE_STRING) : null;

    if($service && in_array($service, ['clear-log','clear'])){
        if($service == 'clear-log'){
            $message = "Image log cleared";

            $logsPath = __DIR__.'/logs';
            $f = @fopen($logsPath, "r+");
            if ($f !== false) {
                ftruncate($f, 0);
                fclose($f);
            }
        }
        if($service == 'clear'){
            $message = "Image cache cleared";
            clearCache();
        }
    }

    $directory = "/path/to/dir/";
    $filecount = 0;
    $files = glob($directory . "*");
    if ($files){
        $filecount = count($files);
    }

    $totalCacheFiles = getCacheFilesCount();

    include __DIR__.'/inc/admin.php';
    return;
}

function logPageHandler()
{
    $logsPath = __DIR__.'/logs';
    echo '<pre>';
    include $logsPath;
    echo '</pre>';

}

function getCacheFilesCount()
{
    $cacheFolder = ImageManager::getCacheFolder()."/*";
    $files = glob($cacheFolder); // get all file names
    return count($files);
}

function clearCache()
{
    $cacheFolder = ImageManager::getCacheFolder()."/*";
    $files = glob($cacheFolder); // get all file names
    foreach($files as $file){ // iterate files
        if(is_file($file)){
            unlink($file);
        }
    }
}
