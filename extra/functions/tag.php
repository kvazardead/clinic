<?php

function get_dir_contents($dir, $filter = '', &$results = array()) {
    $files = scandir($dir);

    foreach($files as $key => $value){
        $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 

        if(!is_dir($path)) {
            if(empty($filter) || preg_match($filter, $path)) $results[] = $path;
        } elseif($value != "." && $value != "..") {
            get_dir_contents($path, $filter, $results);
        }
    }

    return $results;
}

function parad($title, $value) {
    echo "<pre style=\"background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;\">";
    echo "<strong style=\"color: #ffffff;\">$title</strong><br>";
    print_r($value);
    echo "</pre>";
}

function dd($value) {
    echo "<pre style=\"background-color: black; color: #00ff00; border-style: solid; border-color: #ff0000; border-width: medium;\">";
    print_r($value);
    echo "</pre>";
}

function api( $url, $param ){
    if ($url) {
        return DIR."/api/$url".EXT."?url=$param";
    }
}

function global_render( $url=null ){
    if ($url) {
        header("location:".DIR."$url".EXT);
    }else {
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

function render($url=null){
    if ($url) {
        header("location:".DIR."/views/$url".EXT);
    }else {
        header("location:".$_SERVER['HTTP_REFERER']);
    }
    exit;
}

function index(){
    header("location:".DIR."/index".EXT);
    exit;
}

function layout($url){
    return $_SERVER['DOCUMENT_ROOT'].DIR."/views/layout/$url.php";
}

function viv($url=null){
    if ($url) {
        return DIR."/views/$url".EXT;
    }else {
        return DIR."/";
    }
}

function viv_link($url, $class = ""){

    if (is_array($url)) {
        
        foreach ($url as $value) {
            if (EXT == ".php") {
                if (viv($value) == $_SERVER['PHP_SELF']) {
                    return "active $class";
                }
            } else {
                if (viv($value).".php" == $_SERVER['PHP_SELF']) {
                    return "active $class";
                }
            }
        }

    } else {
        if (EXT == ".php") {
            if (viv($url) == $_SERVER['PHP_SELF']) {
                return "active $class";
            }
        } else {
            if (viv($url).".php" == $_SERVER['PHP_SELF']) {
                return "active $class";
            }
        }
    }
}

function prints($url=null){
    return DIR."/prints/default-$url".EXT;
}

// function img($url){
//     return DIR."/static/$url";
// }

function stack($url){
    return DIR."/static/$url";
}

function node($url){
    return DIR."/node_modules/$url";
}

function ajax($url)
{
    return DIR."/ajax/$url".EXT;
}


function add_url(){
    return DIR."/hook/create_to_update".EXT."?";
}

function del_url($id = null, $model = null, $arg = "?"){
    if($id) $arg .= "id=$id";
    if($model) $arg .= "&model=$model";
    return DIR."/hook/delete".EXT.$arg;
}

function up_url($id = null, $model, $form = 'form', $arg = "?"){
    if($id) $arg .= "id=$id";
    if($model) $arg .= "&model=$model";
    if($form) $arg .= "&form=$form";
    return DIR."/hook/get".EXT.$arg;
}

function download_url($model, $file_name, $is_null = false){
    return DIR."/hook/download".EXT."?model=$model&file=$file_name&is_null=$is_null";
}
?>