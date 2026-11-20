<?php
require "config.php";
loginRequired();
$active = "reports";
$items = array_reverse(readData("items.json"));
$mine = [];
foreach ($items as $item) if ($item["posted_by"] === currentUser()) $mine[] = $item;
$pageTitle = "My reports";
require "header.php";
?>
<div class="page-intro"><div><span class="eyebrow">YOUR ACTIVITY</span><h1>My reports</h1><p>See the items you have shared with the community.</p></div><a class="button" href="report.php">＋ New report</a></div>
<?php if (isset($_GET["posted"])): ?><div class="success">Your report has been published successfully.</div><?php endif; ?>
<div class="cards">
<?php if (!$mine): ?><div class="empty">You have not posted any reports yet.</div><?php endif; ?>
<?php foreach ($mine as $item): ?>
    <article class="item-card"><?php if (!empty($item["image"])): ?><img class="item-image" src="<?= clean($item["image"]) ?>" alt="Item photo"><?php else: ?><div class="placeholder">✳</div><?php endif; ?><div class="item-info"><span class="tag <?= strtolower(clean($item["type"])) ?>"><?= clean($item["type"]) ?></span><?php if (($item["status"] ?? "") === "Returned"): ?><span class="tag returned">Returned</span><?php endif; ?><h4><?= clean($item["title"]) ?></h4><p class="muted">⌖ <?= clean($item["location"]) ?></p><a class="text-link" href="item.php?id=<?= clean($item["id"]) ?>">Open report →</a></div></article>
<?php endforeach; ?>
</div>
<?php require "footer.php"; ?>