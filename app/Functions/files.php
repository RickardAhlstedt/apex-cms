<?php

function cleanFileName($file_name){
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_name_str = pathinfo($file_name, PATHINFO_FILENAME);

    // Replaces all spaces with hyphens.
    $file_name_str = str_replace(' ', '-', $file_name_str);
    // Removes special chars.
    $file_name_str = preg_replace('/[^A-Za-z0-9\-\_]/', '', $file_name_str);
    // Replaces multiple hyphens with single one.
    $file_name_str = preg_replace('/-+/', '-', $file_name_str);

    $clean_file_name = $file_name_str.'.'.$file_ext;

    return $clean_file_name;
}
