<?php

defined('SYSPATH') or die('No direct script access.');

class Kohana_Uploader {

    private $allowedExtensions = array();
    private $sizeLimit = 10485760;
    private $file;

    function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
        $allowedExtensions = array_map("strtolower", $allowedExtensions);

        $this->allowedExtensions = $allowedExtensions;
        $this->sizeLimit = $sizeLimit;

        if (isset($_GET['qqfile'])) {
            $this->file = new Kohana_Uploader_XHR();
        } elseif (isset($_FILES['qqfile'])) {
            $this->file = new Kohana_Uploader_Form();
        } else {
            $this->file = false;
        }
    }

    /**
     * Returns array('success'=>true) or array('error'=>'error message')
     */
    function handleUpload($uploadDirectory, $replaceOldFile = FALSE) {
        if (!is_writable($uploadDirectory)) {
            return array('error' => "Server error. Upload directory isn't writable.");
        }

        if (!$this->file) {
            return array('error' => 'No files were uploaded.');
        }

        $size = $this->file->getSize();

        if ($size == 0) {
            return array('error' => 'File is empty');
        }

        if ($size > $this->sizeLimit) {
            return array('error' => 'File is too large');
        }

        $pathinfo = pathinfo($this->file->getName());
        $filename = $pathinfo['filename'];
        $hash = md5(uniqid());
        $ext = $pathinfo['extension'];

        if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
            $these = implode(', ', $this->allowedExtensions);
            return array('error' => 'File has an invalid extension, it should be one of ' . $these . '.');
        }

        if (!$replaceOldFile) {
            /// don't overwrite previous files that were uploaded
            while (file_exists($uploadDirectory . $hash . '.' . $ext)) {
                $hash = md5(uniqid());
            }
        }

        if ($this->file->save($uploadDirectory . $hash . '.' . $ext)) {
            return array(
                'success' => true,
                'filename' => $filename,
                'extension' => $ext,
                'hash' => $hash,
                'path' => $uploadDirectory . $hash . '.' . $ext,
            );
        } else {
            return array('error' => 'Could not save uploaded file.' .
                'The upload was cancelled, or server error encountered');
        }
    }

}
