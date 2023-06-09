<?php

/* set the answer format */
header('Content-Type: text/json');
require_once("config.php");

$action = $_POST['action'];
$version = $_POST['version'];

/* contains the DB query string */
$query_string = "";

/* handle different query types */
switch ($action) {

    case "getFeatures" :
        //echo($action);
        getFeatures($version);
        break;

    case "getDetails" :
        getDetails($version);
        break;

    case "getDetailIDs":
        getDetailIDs($version);
        break;

}


function getFeatures($version)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

    if ($version == 1) {
        $sql = 'SELECT * FROM pythonfeatures';
    } else {
        $sql = 'SELECT * FROM features5descriptors';
    }

    $result = mysqli_query($conn, $sql);
    $features = array();

    // loop over results
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $artwork = $row['artwork'];
        $detail_features = $row['features'];
        $distance = $row['distance'];

        $feature = array('artwork' => $artwork, 'features' => $detail_features, 'distance' => $distance);
        array_push($features, $feature);
    }

    echo json_encode($features);
    mysqli_close($conn);
}

function getDetails($version)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if (!$conn) {
        error_log('Connection error: ' . mysqli_connect_error());
    }
    /* change character set to utf8 | Object Oriented*/
    if (!$conn->set_charset("utf8")) {
        error_log("Error loading character set utf8: %s\n", $conn->error);
    }

    if (isset($_POST['lang'])) {
        $lang = $_POST['lang'];
    } else {
        echo "lang not set error";
        error_log("lang not set");
        return;
    }
    if ($version == 2) {
        if ($lang == 'it') {
            $sql = "SELECT * FROM details5descriptors_it";
        } else if ($lang == 'en') {
            $sql = "SELECT * FROM details5descriptors_en";
        }
    } else {
        if ($lang == 'it') {
            $sql = "SELECT * FROM details_it";
        } else if ($lang == 'en') {
            $sql = "SELECT * FROM details_en";
        }
    }

    $result = mysqli_query($conn, $sql);
    error_log('SQL query: ' . $sql); // debugging
    $details = array();

    // loop over results
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
        $id = $row['id'];
        $detail_name = $row['detail-name'];
        $artwork = $row['artwork'];
        $author = $row['author'];
        $image = $row['image'];
        $detail_icon = $row['detail-icon'];
        $description = $row['description'];
        $audio_guide = $row['audio-guide'];
        $video = $row['video'];
        $artwork_id = $row['artwork-id'];

        $details[$id] = array('detail-name' => $detail_name, 'artwork' => $artwork, 'author' => $author, 'image' => $image,
            'detail-icon' => $detail_icon, 'description' => $description, 'audio-guide' => $audio_guide, 'video' => $video,
            'artwork-id' => $artwork_id);
        foreach ($details[$id] as $key => $value) {
            error_log($key . ":" . $value);
        }
    }
    error_log('details num rows: ' . count($details));
    error_log('JSON details: ' . json_encode($details, JSON_PARTIAL_OUTPUT_ON_ERROR));
    echo json_encode($details);
    mysqli_close($conn);
}


function getDetailIDs($version)
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
    if (!$conn) {
        echo 'Connection error: ' . mysqli_connect_error();
    }

    if ($version == 3) {
        $sql = 'SELECT * FROM id_objdet_mapping';
    } else {
        $sql = 'SELECT * FROM id_class_mapping';
    }

    $result = mysqli_query($conn, $sql);
    $detailIDs = array();

    // loop over results
    while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

        $id = $row['id'];
        $id_net = $row['id_net'];
        $confidence = $row['confidence'];
        $detailIDs[$id_net] = array('id' => $id, 'confidence' => $confidence);
    }

    echo json_encode($detailIDs);
    mysqli_close($conn);
}
