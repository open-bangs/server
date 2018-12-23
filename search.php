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



    function getFallbackUrl($query) {
        global $fallback;

        return str_replace("%s", $query, $fallback);
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

    $query = $_GET["q"];

    $bang_keyword = containsBangs($query);

    if($bang_keyword) {
        $url = array_search($bang, $bangs);

        // TODO: Replace hacky script
        foreach($bangs as $bang) {
            if($bang["keyword"] == "$bang_keyword") {
                print_r($bang);

                $cleaned_query = str_replace("!$bang", "", $query);

                header("Location: " . str_replace("%s", $cleaned_query, $bang["url"]));

                // Exit so no Exception is thrown
                exit();
            }
        }

        // Throw Exception if not found
        throw new Exception();
    } else {
        header("Location: " . getFallbackUrl($query));
    }