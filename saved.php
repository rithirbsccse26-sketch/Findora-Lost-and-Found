<?php
require "config.php";
loginRequired();
$active = "saved";
$saved = readData("saved.json");
$ids = $saved[currentUser()] ?? [];
$items = array_reverse(readData("items.json"));
$mine = [];
foreach ($items as $item) if (in_array($item["id"], $ids)) $mine[] = $item;
$pageTitle = "Saved items";
require "header.php";
?>
<div class="page-intro"><div><span class="eyebrow">KEEP AN EYE ON IT</span><h1>Saved items</h1><p>Listings you have bookmarked for later.</p></div></div>
<div class="cards">
<?php if (!$mine): ?><div class="empty">You haven't saved any items yet. Browse listings and press Save item.</div><?php endif; ?>
<?php foreach ($mine as $item): ?><article class="item-card"><?php if (!empty($item["image"])): ?><img class="item-image" src="<?= clean($item["image"]) ?>" alt="Item photo"><?php else: ?><div class="placeholder">♡</div><?php endif; ?><div class="item-info"><span class="tag <?= strtolower(clean($item["type"])) ?>"><?= clean($item["type"]) ?></span><h4><?= clean($item["title"]) ?></h4><p class="muted">⌖ <?= clean($item["location"]) ?></p><a class="text-link" href="item.php?id=<?= clean($item["id"]) ?>">View item →</a></div></article><?php endforeach; ?>
</div>
<?php require "footer.php"; ?>