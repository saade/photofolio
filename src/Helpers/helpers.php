<?php

if (!function_exists('photofolio_asset')) {
    function photofolio_asset($path, $cache=false)
    {
        $version = $cache ? '&version='.uniqid() : '';
        return route('photofolio_assets').'?path='.urlencode($path).$version;
    }
}

/*
 * php delete function that deals with directories recursively
 */
if (!function_exists('rrmdir')) {
    function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") {
                        rrmdir($dir."/".$object);
                    } else {
                        unlink($dir."/".$object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}
