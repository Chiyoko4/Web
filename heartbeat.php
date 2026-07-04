<?php

session_start();

require "config/koneksi.php";

if (!isset($_SESSION["username"])) {

    exit;

}

$db->users->updateOne(

    [

        "username" => $_SESSION["username"]

    ],

    [

        '$set' => [

            "last_active" => date("Y-m-d H:i:s")

        ]

    ]

);