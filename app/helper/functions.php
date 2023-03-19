<?php

use \Illuminate\Support\Facades\File;

function getLangError()
{
    return File::getRequire(base_path() .DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'helper'.DIRECTORY_SEPARATOR.'error.php');
}


function DateFormat(string $date): string
{
    return date('Y/m/d | h:i A', strtotime($date)); //| h:s A
}
