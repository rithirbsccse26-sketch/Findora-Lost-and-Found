<?php
session_start();

/* Read information from a JSON file */
function readData($file) {
    $path = __DIR__ . "/data/" . $file;
    if (!file_exists($path)) return [];
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

/* Save information in a JSON file */
function saveData($file, $data) {
    file_put_contents(__DIR__ . "/data/" . $file,
        json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
}

function clean($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, "UTF-8");
}

function loggedIn() {
    return isset($_SESSION["user"]);
}

function loginRequired() {
    if (!loggedIn()) {
        header("Location: login.php");
        exit;
    }
}

function currentUser() {
    return $_SESSION["user"] ?? "";
}

function getItem($id) {
    $items = readData("items.json");
    foreach ($items as $item) {
        if ($item["id"] === $id) return $item;
    }
    return null;
}

/* Save an optional photo uploaded from the user's device. */
function saveUploadedPhoto($fieldName = "image") {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]["error"] === UPLOAD_ERR_NO_FILE) {
        return "";
    }

    if ($_FILES[$fieldName]["error"] !== UPLOAD_ERR_OK) {
        throw new RuntimeException("The photo could not be uploaded. Please try again.");
    }

    $file = $_FILES[$fieldName];
    if ($file["size"] > 5 * 1024 * 1024) {
        throw new RuntimeException("Please choose a photo smaller than 5 MB.");
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file["tmp_name"]);
    $allowed = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/gif" => "gif",
        "image/webp" => "webp"
    ];
    if (!isset($allowed[$mime])) {
        throw new RuntimeException("Please upload a JPG, PNG, GIF or WEBP image.");
    }

    $uploadDir = __DIR__ . "/uploads";
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        throw new RuntimeException("The upload folder could not be created.");
    }

    $fileName = bin2hex(random_bytes(12)) . "." . $allowed[$mime];
    if (!move_uploaded_file($file["tmp_name"], $uploadDir . "/" . $fileName)) {
        throw new RuntimeException("The photo could not be saved. Please try again.");
    }

    return "uploads/" . $fileName;
}

function messageCount($username) {
    $messages = readData("messages.json");
    $count = 0;
    foreach ($messages as $message) {
        if ($message["owner"] === $username && empty($message["read"])) $count++;
    }
    return $count;
}
?>