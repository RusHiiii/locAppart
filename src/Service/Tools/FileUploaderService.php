<?php
namespace App\Service\Tools;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploaderService
{
    private $targetDirectory;

    public function __construct(
        $targetDirectory
    )
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * UPLOAD DU FICHIER
     * @param UploadedFile $file
     * @return array
     */
    public function upload(UploadedFile $file): array
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            return [
                'filename' => null,
                'upload' => false
            ];
        }

        return [
            'filename' => $fileName,
            'upload' => true
        ];
    }

    /**
     * RECUPERATION DU REPERTOIRE D'UPLOAD
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
