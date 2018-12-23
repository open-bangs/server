<?php
    require_once("config.php");
    
    // PARSE DATA
    $data = json_decode(file_get_contents("./dataset/data.json"), true);

    $allowed_data_version = 1;

    if($data["version"] != $allowed_data_version) {
        $err = "Version of data is invalid. Please update your open-bangs server.";

        print("ERROR: " . $err);
        throw new Exception($err);
    }
        
    $bangs = $data["data"];


    $query = $_GET["q"];
    $upstream = $_GET["upstream"];


    $upstream_data = $upstreams[$upstream];

    if(!$upstream_data) {
        $err = "Upstream not found.";

        print("ERROR: " . $err);
        // throw new Exception($err);
        exit();
    }

    $upstream_url = $upstream_data["url"];
    


    function getFallbackUrl($query, $upstream) {
        global $upstream_url;

        return str_replace("%s", $query, $upstream_url);
    }

    function containsBangs($query) {
        global $bangs;

        foreach($bangs as $bang) {
            $keyword = $bang["keyword"];

            // FIXME: do not match "!bang2" if "bang"
            $found = preg_match("/(!$keyword)/", $query);

            if($found == true) {
                return $keyword;
            }
        }
        return false;
    }

    $bang_keyword = containsBangs($query);

    if($bang_keyword) {
        // TODO: Replace hacky script
        foreach($bangs as $bang) {
            if($bang["keyword"] == "$bang_keyword") {
                $cleaned_query = str_replace("!$bang_keyword", "", $query);

                header("Location: " . str_replace("%s", $cleaned_query, $bang["url"]));

                // Exit so no Exception is thrown
                exit();
            }
        }

        // Throw Exception if not found
        throw new Exception();
    } else {
        header("Location: " . getFallbackUrl($query, $upstream));
    }