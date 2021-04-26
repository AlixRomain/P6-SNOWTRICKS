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
     * @param      $trick
     * @param      $main_file
     * @param null $main_image
     * @param      $directory_pass
     *
     * @return mixed
     */
    public function uploadMainImage($trick, $main_file, $directory_pass, $main_image = null ){
        if(!is_null($main_file)){
            /*Change path before move file in media directory*/
            $trick->setPath($directory_pass.'/');
            ($main_image !== null)?$trick->setOldPath($main_image): null;
            $trick->setMainImage($main_file->getBasename());
        }
        return $trick;
    }


}