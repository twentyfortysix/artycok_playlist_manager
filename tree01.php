<?php
echo dirname(__FILE__);
$path = '.';//dirname(__FILE__);
$level = 0;
$directory_array = array();
function getDirectory( $path, $level ){ 

    $ignore = array( 'cgi-bin', '.', '..' ); 
    // Directories to ignore when listing output. Many hosts 
    // will deny PHP access to the cgi-bin. 

    $dh = @opendir( $path ); 
    $i = 0;
    // Open the directory to the handle $dh 
    while( false !== ( $file = readdir( $dh ) ) ){ 
    // Loop through the directory 
        if( !in_array( $file, $ignore ) ){ 
        // Check that this file is not to be ignored 
             
            $spaces = str_repeat( '&nbsp;', ( $level * 4 ) ); 
            // Just to add spacing to the list, to better 
            // show the directory tree. 
             
            if( is_dir( "$path/$file" ) ){ 
            // Its a directory, so we need to keep reading down... 
             
                echo "<strong style='color:red'>$spaces $file</strong><br />"; 
                getDirectory( "$path/$file", ($level+1) ); 
                // Re-call this same function but on a new directory. 
                // this is what makes function recursive. 
                //~ $directory_array
             
            } else { 
             
                echo "$spaces $file<br />"; 
                // Just print out the filename 
             
            } 
         
        } 
        $i++;
     
    } 
     echo $i;
    closedir( $dh ); 
    // Close the directory handle 

} 
echo getDirectory( $path, $level );
echo microtime();
