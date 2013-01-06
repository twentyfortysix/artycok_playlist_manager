<?php
// $dir = '.';
$dir = '/var/www/cesnet/data/artycok';
echo date('Y.m.d H:i');

function ReadFolderDirectory($dir,$listDir= array())
{
    $listDir = array();
    if($handler = opendir($dir))
    {
        while (($sub = readdir($handler)) !== FALSE)
        {
            if ($sub != "." && $sub != ".." && $sub != "Thumb.db")
            {
                if(is_file($dir."/".$sub))
                {
                    $listDir[] = $sub;
                }
                elseif(is_dir($dir."/".$sub))
                {
                    $listDir[$sub] = ReadFolderDirectory($dir."/".$sub); 
                } 
            } 
        }    
        closedir($handler); 
    } 
    return $listDir;    
}

echo '<pre>';
//~ var_dump(json_encode(ReadFolderDirectory($dir)));
var_dump(ReadFolderDirectory($dir));
echo '</pre>';
echo date('Y.m.d H:i');
