<?php
require "config.php";
$active = "browse";
$items = array_reverse(readData("items.json"));
$q = trim($_GET["q"] ?? "");
$type = $_GET["type"] ?? "All";
$category = $_GET["category"] ?? "All";
$filtered = [];
foreach ($items as $item) {
    $matchesText = $q === "" || stripos($item["title"]." ".$item["location"]." ".$item["description"], $q) !== false;
    $matchesType = $type === "All" || $item["type"] === $type;
    $matchesCategory = $category === "All" || $item["category"] === $category;
    if ($matchesText && $matchesType && $matchesCategory) $filtered[] = $item;
}
$pageTitle = "Browse items";
require "header.php";
?>
<div class="page-intro"><div><span class="eyebrow">THE COMMUNITY BOARD</span><h1>Browse lost & found.</h1><p>Search reports shared by people in your community.</p></div><a class="button" href="report.php">＋ Create a report</a></div>
<form class="filters" method="GET">
    <input name="q" value="<?= clean($q) ?>" placeholder="Search item or location...">
    <select name="type"><option <?= $type==="All"?"selected":"" ?>>All</option><option <?= $type==="Lost"?"selected":"" ?>>Lost</option><option <?= $type==="Found"?"selected":"" ?>>Found</option></select>
    <select name="category"><option <?= $category==="All"?"selected":"" ?>>All</option><?php foreach (["Electronics","Bags","Clothing","Accessories","Documents","Other"] as $c): ?><option <?= $category===$c?"selected":"" ?>><?= $c ?></option><?php endforeach; ?></select>
    <button class="button" type="submit">Search</button>
</form>
<div class="result-line"><b><?= count($filtered) ?> items</b><span class="muted">Newest first</span></div>
<div class="cards">
<?php if (!$filtered): ?><div class="empty">No items match your search. Try different filters.</div><?php endif; ?>
<?php foreach ($filtered as $item): ?>
    <article class="item-card">
        <?php if (!empty($item["image"])): ?><img class="item-image" src="<?= clean($item["image"]) ?>" alt="Item photo"><?php else: ?><div class="placeholder">✳</div><?php endif; ?>
        <div class="item-info"><span class="tag <?= strtolower(clean($item["type"])) ?>"><?= clean($item["type"]) ?></span><?php if (($item["status"] ?? "") === "Returned"): ?><span class="tag returned">Returned</span><?php endif; ?><h4><?= clean($item["title"]) ?></h4><p class="muted">⌖ <?= clean($item["location"]) ?></p><p class="description"><?= clean($item["description"]) ?></p><a class="text-link" href="item.php?id=<?= clean($item["id"]) ?>">View details →</a></div>
    </article>
<?php endforeach; ?>
</div>
<?php require "footer.php"; ?>