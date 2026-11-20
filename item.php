<?php
require "config.php";
$id = $_GET["id"] ?? "";
$item = getItem($id);
if (!$item) { header("Location: index.php"); exit; }
$savedItems = loggedIn() ? (readData("saved.json")[currentUser()] ?? []) : [];
$isSaved = in_array($id, $savedItems);
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    loginRequired();
    $message = trim($_POST["message"] ?? "");
    if ($message === "") {
        $error = "Please write a message first.";
    } elseif (currentUser() === $item["posted_by"]) {
        $error = "You cannot contact yourself about your own report.";
    } else {
        $messages = readData("messages.json");
        $messages[] = [
            "id" => uniqid("msg_"), "item_id" => $id,
            "owner" => $item["posted_by"], "from" => currentUser(),
            "item_title" => $item["title"], "message" => $message,
            "date" => date("d M Y, g:i a"), "read" => false
        ];
        saveData("messages.json", $messages);
        header("Location: item.php?id=" . urlencode($id) . "&sent=1");
        exit;
    }
}
$pageTitle = "Item details";
$active = "browse";
require "header.php";
?>
<a class="back" href="index.php">← Back to browse</a>
<?php if (isset($_GET["sent"])): ?><div class="success">Your message has been sent to the person who posted this item.</div><?php endif; ?>
<?php if (isset($_GET["saved"])): ?><div class="success">This item has been added to your saved items.</div><?php endif; ?>
<div class="detail-layout">
    <section class="detail-card">
        <?php if (!empty($item["image"])): ?><img class="detail-image" src="<?= clean($item["image"]) ?>" alt="Item photo"><?php else: ?><div class="detail-placeholder">✳</div><?php endif; ?>
        <div class="detail-body">
            <span class="tag <?= strtolower(clean($item["type"])) ?>"><?= clean($item["type"]) ?></span>
            <?php if (($item["status"] ?? "") === "Returned"): ?><span class="tag returned">Returned</span><?php endif; ?>
            <h1><?= clean($item["title"]) ?></h1>
            <p class="muted">⌖ <?= clean($item["location"]) ?> · <?= clean($item["category"]) ?></p>
            <p class="detail-description"><?= clean($item["description"]) ?></p>
            <?php if (!loggedIn()): ?>
                <a class="button secondary" href="login.php">♡ Log in to save item</a>
            <?php elseif ($isSaved): ?>
                <button class="button secondary" type="button" disabled>♥ Saved to your items</button>
            <?php else: ?>
                <form method="POST" action="save-item.php" class="save-form">
                    <input type="hidden" name="id" value="<?= clean($id) ?>">
                    <button class="button secondary" type="submit">♡ Save item</button>
                </form>
            <?php endif; ?>
            <div class="posted"><div class="avatar"><?= strtoupper(substr($item["posted_by"],0,1)) ?></div><div><small>POSTED BY</small><b><?= clean($item["posted_by"]) ?></b></div><span><?= clean($item["date"]) ?></span></div>
            <?php if (loggedIn() && currentUser() === $item["posted_by"] && ($item["status"] ?? "") !== "Returned"): ?>
                <form method="POST" action="status.php" class="status-form"><input type="hidden" name="id" value="<?= clean($id) ?>"><button class="button secondary" type="submit">Mark as returned</button></form>
            <?php endif; ?>
        </div>
    </section>
    <aside class="contact-card">
        <span class="eyebrow">GET IN TOUCH</span>
        <h2>Know something?</h2>
        <p class="muted">Send a message directly to the person who posted this report. Please include your contact number so they can reach you and arrange the safe return of the item. Share your number only if you are comfortable.</p>
        <?php if ($error): ?><div class="error"><?= clean($error) ?></div><?php endif; ?>
        <?php if (!loggedIn()): ?>
            <a class="button full" href="login.php">Log in to contact</a>
        <?php elseif (currentUser() === $item["posted_by"]): ?>
            <p class="muted">This is your report. You can check replies in your Messages inbox.</p>
        <?php else: ?>
            <form method="POST" class="form">
                <label>Your message<textarea name="message" rows="5" required placeholder="Hi, I have information about this item. You can reach me at..."></textarea></label>
                <button class="button full" type="submit">Send message →</button>
            </form>
        <?php endif; ?>
        <p class="privacy-note">Messages are sent to the report owner and are not shown publicly.</p>
    </aside>
</div>
<?php require "footer.php"; ?>