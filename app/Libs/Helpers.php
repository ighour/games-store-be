<?php

namespace App\Libs;

abstract class Helpers {

    /**
     * Check string starting with given substring
     */
    public static function startsWith($string, $startString)
    {
        $len = strlen($startString);
    
        return (substr($string, 0, $len) === $startString); 
    }

    /**
     * Check number of digits after decimal point
     */
    public static function numberDecimals($number)
    {
        $exploded = explode(".", $number);

        return strlen($exploded[1]);
    }

    /**
     * Handle Files
     */
    public static function storeFile($paramName, $to)
    {
        //Dir
        $baseDir = __BASE_PATH__ . '/../public/storage';

        //Allowed Extensions
        $extensions = ['png'];

        //Check parameter
        if(!isset($_FILES[$paramName]))
            throw new \Exception("File not uploaded.");

        //Get file info
        $name = $_FILES[$paramName]['name'];
        $size = $_FILES[$paramName]['size'];
        $tempName = $_FILES[$paramName]['tmp_name'];
        $type = $_FILES[$paramName]['type'];
        $nameParts = explode('.',$name);
        $extension = strtolower($nameParts[sizeOf($nameParts) - 1]);

        //Check extension
        if(!in_array($extension, $extensions))
            throw new \Exception("Only png extension is supported.");

        //Check size
        if($size > 1000000)
            throw new \Exception("Max file size is 1MB.");

        //Set save info
        $saveName = hash("sha256", microtime(true) . $name) . '.' . $extension;
        $saveDir = $to == 'avatars' ? $baseDir . '/avatars' : $baseDir . '/games';
        $savePath = $saveDir . '/' . basename($saveName);

        //Move file
        $uploaded = move_uploaded_file($tempName, $savePath);

        //Error moving
        if(!$uploaded)
            throw new \Exception ("Error uploading file.");

        //All OK
        return $saveName;
    }

    /**
     * Retrieve file
     */
    public static function retrieveFile($folder, $name)
    {
        $root = __PUBLIC_PATH__;

        //Default images
        if($folder == 'img')
            Helpers::returnFile($root . '/img' . '/' . $name);

        //Users avatars
        else if($folder == 'avatars')
            Helpers::returnFile($root . '/storage/avatars' . '/' . $name);
    }

    /**
     * Generate response for File
     */
    public static function returnFile($path)
    {
        if(file_exists($path)){
            $file = fopen($path, 'rb');

            header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
            header("Content-Type: image/png");
            header("Content-Length:".filesize($path));

            fpassthru($file);
            die();
        }  
    }

    /**
     * Delete file
     */
    public static function deleteFile($folder, $name)
    {
        if(is_null($folder) || is_null($name))
            return;

        $root = __PUBLIC_PATH__ . '/storage';

        //Users avatars
        if($folder == 'avatars'){
            $path = $root . '/avatars' . '/' . $name;

            if(file_exists($path)){
                unlink($path);
            }
        }

        //Users avatars
        else if($folder == 'games'){
            $path = $root . '/games' . '/' . $name;

            if(file_exists($path)){
                unlink($path);
            }
        }
    }
}