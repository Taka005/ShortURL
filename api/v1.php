<?php
    require "../config.php";
    header('Content-Type: application/json; charset=UTF-8');

    if($_GET["key"]){
        $api_key = htmlspecialchars($_GET["key"]);
        $key = json_decode(file_get_contents("../data/key.json"));

        if($api_key === $password){
            $random = substr(str_shuffle("abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZY0123456789"),0,15);
            array_push($key,$random);
            file_put_contents("../data/key.json",json_encode($key,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR));

            $res["success"] = true;
            $res["message"] = null;
            $res["data"] = $random;
        }else if(in_array($api_key,$key)){
            if($_GET["url"]){
                $url = htmlspecialchars($_GET["url"]);
                $urls = json_decode(file_get_contents("../data/url.json"),true);

                if(preg_match("/^(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i", $url)){
                    $random = substr(str_shuffle("abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWZY0123456789"),0,8);
                    $urls[$random] = $url;
                    file_put_contents("../data/url.json",json_encode($urls,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR));

                    $res["success"] = true;
                    $res["message"] = null;
                    $res["data"] = "https://tlti.tk/".$random;
                }else{
                    $res["success"] = true;
                    $res["message"] = "URL required";
                    $res["data"] = null;
                }
            }else{
                $res["success"] = false;
                $res["message"] = "Parameter not found";
                $res["data"] = null;
            }
        }else{
            $res["success"] = false;
            $res["message"] = "Wrong API Key";
            $res["data"] = null;
        }
    }else{
        $res["success"] = false;
        $res["message"] = "Parameter not found";
        $res["data"] = null;
    }
    
    print json_encode($res,JSON_UNESCAPED_SLASHES|JSON_PARTIAL_OUTPUT_ON_ERROR);
?>