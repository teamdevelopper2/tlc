<?php
/**
 * Created by PhpStorm.
 * User: Aly Seck
 * Date: 07/07/2017
 * Time: 15:39
 */

namespace TeamDeveloppe\UploadBundle\Handler;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccess;

class UploadHandler
{

    private $accessor;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function UploadFIle($entity, $property, $annotation) {
        $file = $this->accessor->getValue($entity,$property);
        //var_dump($annotation);
        if ($file instanceof UploadedFile) {
            $this->removeOldFile($entity, $annotation);
            $filename = $file->getClientOriginalName();
            $file->move($annotation->getPath(), $filename );
            $this->accessor->setValue($entity, $annotation->getFilename(), $filename);
        }
    }

    public function setFileFromFilename($entity, $property, $annotation)
    {
        $file = $this->getFileFromFilename($entity,$annotation);
        $this->accessor->setValue($entity, $property, $file);
    }

    public function removeOldFile($entity, $annotation)
    {
        var_dump($annotation);
        $file = $this->getFileFromFilename($entity,$annotation);
        if ($file !== null) {
            @unlink($file->getRealPath());
        }
    }

    /**
     * @param $entity
     * @param $annotation
     * @return null|File
     */
    private function getFileFromFilename($entity, $annotation) {
//        var_dump($annotation);
        $name = $annotation->getFilename();
      // var_dump($name);
        $filename =  $this->accessor->getValue($entity, $name);
        if (empty($filename)){
            return null;
        }else {
            return new File($annotation->getPath(). DIRECTORY_SEPARATOR . $filename);
        }
    }

    public function removeFile($entity, $property)
    {
        $file = $this->accessor->getValue($entity,$property);
        if ($file instanceof File) {
            @unlink($file->getRealPath());
        }
    }
}