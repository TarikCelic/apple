<?php

function connect_db($state)
{
    if ($state == 1) {
        return [
            "host" => "localhost",
            "user" => "root",
            "pass" => "",
            "name" => "apple",
        ];
    } else if ($state == 2) {
        return [
            "host" => "sql110.infinityfree.com",
            "user" => "if0_40468785",
            "pass" => "tarik1234p",
            "name" => "if0_40468785_t",
        ];
    }
}

$config = connect_db(1);

$conn = mysqli_connect(
    $config["host"],
    $config["user"],
    $config["pass"],
    $config["name"]
);

if ($conn) {
    echo '';
} else {
    echo "Greška: " . mysqli_connect_error();
}
