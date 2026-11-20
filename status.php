<?php
require "config.php";
loginRequired();
$id = $_POST["id"] ?? "";
$items = readData("items.json");
foreach ($items as &$item) {
    if ($item["id"] === $id && $item["posted_by"] === currentUser()) {
        $item["status"] = "Returned";
    }
}
unset($item);
saveData("items.json", $items);
header("Location: item.php?id=" . urlencode($id));
exit;
?>