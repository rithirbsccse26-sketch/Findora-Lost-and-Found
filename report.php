<?php
require "config.php";
loginRequired();
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"] ?? "");
    $type = $_POST["type"] ?? "Lost";
    $category = $_POST["category"] ?? "Other";
    $location = trim($_POST["location"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $image = "";
    if ($title === "" || $location === "" || $description === "") {
        $error = "Please fill in the item name, location and description.";
    } else {
        try {
            $image = saveUploadedPhoto("image");
        } catch (RuntimeException $uploadError) {
            $error = $uploadError->getMessage();
        }
    }
    if ($error === "") {
        $items = readData("items.json");
        $items[] = [
            "id" => uniqid("item_"), "title" => $title, "type" => $type,
            "category" => $category, "location" => $location,
            "description" => $description, "image" => $image,
            "posted_by" => currentUser(), "date" => date("d M Y"), "status" => "Open"
        ];
        saveData("items.json", $items);
        header("Location: my-reports.php?posted=1");
        exit;
    }
}
$active = "report";
$pageTitle = "Report lost / found";
require "header.php";
?>
<div class="form-wrap">
    <span class="eyebrow">SHARE A FEW DETAILS</span>
    <h1>Report lost / found</h1>
    <p class="muted">Tell the community what happened. A clear description can help the right person recognise the item.</p>
    <?php if ($error): ?><div class="error"><?= clean($error) ?></div><?php endif; ?>
    <form method="POST" class="form" enctype="multipart/form-data">
        <label>What are you reporting?
            <select name="type"><option>Lost</option><option>Found</option></select>
        </label>
        <label>Item name<input name="title" required placeholder="e.g. Blue backpack"></label>
        <label>Category<select name="category"><?php foreach (["Electronics","Bags","Clothing","Accessories","Documents","Other"] as $c): ?><option><?= $c ?></option><?php endforeach; ?></select></label>
        <label>Location<input name="location" required placeholder="Where was it lost or found?"></label>
        <label>Upload item photo <span class="muted">(optional)</span><input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp"><span class="muted">Choose a photo from your device (JPG, PNG, GIF or WEBP; max 5 MB).</span></label>
        <label>Description<textarea name="description" rows="4" required placeholder="Colour, brand, details and other useful information..."></textarea></label>
        <button class="button" type="submit">Publish report →</button>
    </form>
</div>
<?php require "footer.php"; ?>