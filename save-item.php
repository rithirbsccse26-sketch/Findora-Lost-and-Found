<?php
require "config.php";
loginRequired();
$id = $_POST["id"] ?? "";
if (getItem($id)) {
    $saved = readData("saved.json");
    if (!isset($saved[currentUser()])) $saved[currentUser()] = [];
    if (!in_array($id, $saved[currentUser()])) $saved[currentUser()][] = $id;
    saveData("saved.json", $saved);
}
header("Location: item.php?id=" . urlencode($id) . "&saved=1");
exit;
?>