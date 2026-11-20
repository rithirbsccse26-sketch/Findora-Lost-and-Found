<?php
require "config.php";
loginRequired();
$active = "inbox";
$messages = array_reverse(readData("messages.json"));
$mine = [];
foreach ($messages as $key => $message) {
    if ($message["owner"] === currentUser()) {
        $messages[$key]["read"] = true;
        $mine[] = $message;
    }
}
saveData("messages.json", array_values($messages));
$pageTitle = "Messages";
require "header.php";
?>
<div class="page-intro"><div><span class="eyebrow">CONTACT FROM THE COMMUNITY</span><h1>Your messages</h1><p>People who have information about your reports will appear here.</p></div></div>
<div class="inbox-list">
<?php if (!$mine): ?><div class="empty">No messages yet. When someone contacts you about a report, it will appear here.</div><?php endif; ?>
<?php foreach ($mine as $message): ?><div class="inbox-message"><div class="avatar"><?= strtoupper(substr($message["from"],0,1)) ?></div><div class="message-copy"><b><?= clean($message["from"]) ?> <span>contacted you about <?= clean($message["item_title"]) ?></span></b><p><?= clean($message["message"]) ?></p><small><?= clean($message["date"]) ?></small></div></div><?php endforeach; ?>
</div>
<?php require "footer.php"; ?>