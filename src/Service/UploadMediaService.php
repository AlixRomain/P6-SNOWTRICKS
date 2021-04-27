<?php
namespace App\Service;




/**
 * Class UploadMediaService
 * @package App\Service
 */
class UploadMediaService
{
    /**
     * UploadMediaService constructor.
     */
    public function __construct()
    {

    }


    /**
     * @param $tricks
     *
     * @return mixed
     */
    public function uploadVideoMethod($tricks){
        /*Gestion de l'upload des videos'*/
        $pathRootVideo = 'https://www.youtube.com/embed/';
        foreach ($tricks->getVideos() as $video){
            $video->setTricks($tricks);
            $video->setType('video');
            $video->setName('Une video youtube partenaire de Snowtricks');
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->getPath(), $matches);
            $video->setPath($pathRootVideo . $matches[1]);
        }
        return $tricks;
    }

    /**
     * @param $tricks
     *
     * @param $path
     *
     * @param $oldPath
     *
     * @return mixed
     */
    public function uploadImageMethod($tricks, $path){
        foreach ($tricks->getMedia() as $image) {
            if(!is_null($image->getFile())){
                $image->setType('img');
                $image->setOldPath( $image->getName());
                $image->setPath(substr($image->getFile(), 14, 26));
                $image->setPathDirectory($path.'/');
                $image->setName($image->getPath());
            }
        }
        return $tricks;
    }

    /**
     * @param mixed $object
     * @param        $main_file
     * @param string $directory_pass
     * @param null  $main_image
     *
     * @return mixed
     */
    public function uploadMainImage($object, $main_file, $directory_pass, $main_image = null ){
        // TRICKS main image
        if (method_exists($object, 'setMainImage')) {
            if(!is_null($main_file)){
                /*Change path before move file in media directory*/
                $object->setPath($directory_pass.'/');
                if ($main_image !== null && $main_image !== 'default-image.jpg') {
                    $object->setOldPath($main_image);
                };
                $object->setMainImage($main_file->getBasename());
            }
        } else {
            // USER avatar
            if(!is_null($main_file)){
                /*Change path before move file in media directory*/
                $object->setPathDirectory($directory_pass.'/');
                if ($main_image !== null && $main_image !== 'avatar-default.jpg') {
                    $object->setOldAvatar($main_image);
                }
                $object->setAvatar($main_file->getBasename());
            }
        }

        return $object;
    }


}