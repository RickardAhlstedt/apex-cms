<?php

if( !function_exists( 'getMediaFolders' ) ) {
    function getMediaFolders() {
        $aReturn = [];
        // Get all the folders recursively in the public/images folder
        $aFolders = array_filter( scandir( public_path( 'uploads' ) ), function( $sFolder ) {
            return is_dir( public_path( 'uploads/' . $sFolder ) );
        } );

        foreach( $aFolders as $sFolder ) {
            if( $sFolder == '.' || $sFolder == '..' ) {
                continue;
            }
            $oObject = new stdClass();
            $oObject->name = $sFolder;
            $aReturn[] = $oObject;
        }

        return $aReturn;

    }
}

function listFolders($dir)
{
    echo '<ol>';
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if (!$fileInfo->isDot()) {
            if( $fileInfo->isDir() ) {
                echo '<li>' . $fileInfo->getFilename();
                if ($fileInfo->isDir()) {
                    listFolderFiles($fileInfo->getPathname());
                }
                echo '</li>';
            } else {
                continue;
            }
        }
    }
    echo '</ol>';
}


function listFolderFiles($dir)
{
    echo '<ol>';
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if (!$fileInfo->isDot()) {
            echo '<li>' . $fileInfo->getFilename();
            if ($fileInfo->isDir()) {
                listFolderFiles($fileInfo->getPathname());
            }
            echo '</li>';
        }
    }
    echo '</ol>';
}
