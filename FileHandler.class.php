<?php

// Copyright (C) 2014 Universitätsbibliothek Mannheim
// See file LICENSE for license details.

// Authors: Alexander Wagner, Stefan Weil

// Test whether the script was called directly (used for unit test).
if (!isset($unittest)) {
    $unittest = array();
}
$unittest[__FILE__] = (sizeof(get_included_files()) == 1);



class EogHandler extends FileHandler
{
    function getControls()
    {
        return FileHandler::CURSOR | FileHandler::ZOOM;
    }
    function show($path)
    {
    }
}

class LibreOfficeHandler extends FileHandler
{
    function getControls()
    {
        return FileHandler::CURSOR | FileHandler::ZOOM;
    }
    function show($path)
    {
    }
}

class DwbHandler extends FileHandler
{
    function getControls()
    {
        return FileHandler::CURSOR | FileHandler::ZOOM;
    }
    function show($path)
    {
    }
}

class VlcHandler extends FileHandler
{
    function getControls()
    {
        return FileHandler::CURSOR | FileHandler::ZOOM;
    }
    function show($path)
    {
    }
}

class ZathuraHandler extends FileHandler
{
    function getControls()
    {
        return FileHandler::CURSOR | FileHandler::ZOOM |
               FileHandler::HOME | FileHandler::END |
               FileHandler::PRIOR | FileHandler::NEXT |
               FileHandler::DOWNLOAD;
    }
    function show($path)
    {
    }
}

abstract class FileHandler
{

    // Constants for allowed controls.
    const UP = 1;
    const DOWN = 2;
    const LEFT = 4;
    const RIGHT = 8;
    const ZOOMIN = 16;
    const ZOOMOUT = 32;
    const HOME = 64;
    const END = 128;
    const PRIOR = 256;
    const NEXT = 512;
    const DOWNLOAD = 1024;

    // Shortcuts for combinations of controls.
    const CURSOR = 15; // UP | DOWN | LEFT | RIGHT
    const ZOOM = 48;   // ZOOMIN | ZOOMOUT
    const ALL = 2047;

    // up down left right zoomin zoomout home end prior next download

    // protected $FILES = array();
    // protected $UPLOAD_PATH;

    abstract protected function getControls();
    abstract protected function show($path);

    public static function getFileHandler($file)
    {

        $ftype = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $fhandler = "";
        // $params;
        // echo $ftype;
        switch ($ftype) {
        case 'pdf':
            $fhandler='/usr/bin/zathura';
            break;
        case 'gif':
        case 'jpg':
        case 'png':
            $fhandler='/usr/bin/eog';
            break;
        case 'doc':
        case 'docx':
        case 'odt':
        case 'txt':
        case 'ppt':
        case 'pps':
        case 'ppsx':
        case 'odp':
        case 'xls':
        case 'xlsx':
        case 'ods':
            $fhandler='/usr/bin/libreoffice --nologo --norestore --show';
            break;
        case 'html':
        case 'url':
            $fhandler='/usr/bin/dwb --override-restore';
            break;
        case 'mpg':
        case 'mpeg':
        case 'avi':
        case 'mp3':
        case 'mp4':
            $fhandler?'/usr/bin/cvlc --no-audio';
            break;
        default:
            $fhandler='Unknown';
        }
        /*
        alternatively with mime-types

            // $ftype = mime_content_type($this->UPLOAD_PATH.$file);
            // if($ftype=='application/pdf')
            // if($ftype=='image/gif' || $ftype=='image/jpg' || $ftype=='image/png' )
            // if($ftype=='html' || $ftype=='url' || $ftype="text/plain")
            // (...)

        */

        return $fhandler;
    }
}

if ($unittest[__FILE__]) {
    // Run unit test.
    $dwbHandler = new DwbHandler;
    $zathuraHandler = new ZathuraHandler;
    echo("DOWNLOAD   =" . FileHandler::DOWNLOAD . "\n");
    echo("filehandler=" . FileHandler::getFileHandler("test.txt") . "\n");
    $handler = ${'dwb' . 'Handler'};
    echo("controls   =" . $handler->getControls() . "\n");
}
