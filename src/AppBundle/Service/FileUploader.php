<?php

    namespace AppBundle\Service;

    use Symfony\Component\HttpFoundation\File\UploadedFile;

    class FileUploader
    {
        /**
         * @var
         */
        private $targetDir;

        /**
         * FileUploader constructor.
         * @param $targetDir
         */
        public function __construct($targetDir)
        {
            $this->targetDir = $targetDir;
        }

        /**
         * @param UploadedFile $uploadedFile
         * @return string
         */
        public function upload(UploadedFile $uploadedFile)
        {
            $fileName = uniqid() . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($this->targetDir, $fileName);
            return $fileName;
        }
    }