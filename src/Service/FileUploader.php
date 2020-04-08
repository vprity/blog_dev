<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $target_directory;

    public function __construct($target_directory)
    {
        $this->target_directory = $target_directory;
    }

    public function upload(UploadedFile $file)
    {
        $original_filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safe_filename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $original_filename);
        $file_name = $safe_filename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $file_name);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $file_name;
    }

    public function getTargetDirectory()
    {
        return $this->target_directory;
    }
}