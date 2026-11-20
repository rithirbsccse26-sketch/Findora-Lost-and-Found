<?php
require "config.php";
$active = "dashboard";
$items = array_reverse(readData("items.json"));
$lost = 0; $found = 0; $mine = 0;
foreach ($items as $item) {
    if ($item["type"] === "Lost") $lost++;
    if ($item["type"] === "Found") $found++;
    if (loggedIn() && $item["posted_by"] === currentUser()) $mine++;
}
$recent = array_slice($items, 0, 3);
$pageTitle = "Dashboard";
require "header.php";
?>
<section class="welcome">
    <div>
        <span class="eyebrow">WELCOME TO FINDORA</span>
        <h1>Lost something?<br>Let's find it.</h1>
        <p>A simple community space to report lost items, share found things and help them get home.</p>
        <a class="button button-light" href="report.php">＋ Report lost / found</a>
    </div>
</section>

<div class="section-heading"><div><span class="eyebrow">COMMUNITY OVERVIEW</span><h3>At a glance</h3></div><a class="text-link" href="index.php">Browse all items →</a></div>
<div class="stats">
    <div class="stat"><span class="stat-icon">▤</span><small>Total reports</small><strong><?= count($items) ?></strong><p>Shared by the community</p></div>
    <div class="stat"><span class="stat-icon green">⌕</span><small>Lost items</small><strong><?= $lost ?></strong><p>Waiting to be found</p></div>
    <div class="stat"><span class="stat-icon gold">✦</span><small>Found items</small><strong><?= $found ?></strong><p>Waiting for their owners</p></div>
    <div class="stat"><span class="stat-icon pink">♡</span><small>Your reports</small><strong><?= $mine ?></strong><p>Your shared listings</p></div>
</div>

<div class="section-heading recent"><div><span class="eyebrow">LATEST FROM THE COMMUNITY</span><h3>Recently reported</h3></div></div>
<div class="cards">
<?php if (!$recent): ?><div class="empty">No reports yet. Be the first to share one!</div><?php endif; ?>
<?php foreach ($recent as $item): ?>
    <article class="item-card">
        <?php if (!empty($item["image"])): ?><img class="item-image" src="<?= clean($item["image"]) ?>" alt="Item photo"><?php else: ?><div class="placeholder">✳</div><?php endif; ?>
        <div class="item-info"><span class="tag <?= strtolower(clean($item["type"])) ?>"><?= clean($item["type"]) ?></span><?php if (!empty($item["status"]) && $item["status"] === "Returned"): ?><span class="tag returned">Returned</span><?php endif; ?><h4><?= clean($item["title"]) ?></h4><p class="muted">⌖ <?= clean($item["location"]) ?></p><a class="text-link" href="item.php?id=<?= clean($item["id"]) ?>">View details →</a></div>
    </article>
<?php endforeach; ?>
</div>
<?php require "footer.php"; ?>