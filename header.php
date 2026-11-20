<?php
if (!isset($pageTitle)) $pageTitle = "Dashboard";
if (!isset($active)) $active = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= clean($pageTitle) ?> | Findora</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <a href="dashboard.php" class="brand"><span>f</span> findora</a>
        <p class="side-heading">MENU</p>
        <a class="side-link <?= $active === 'dashboard' ? 'active' : '' ?>" href="dashboard.php">⌂ <span>Dashboard</span></a>
        <a class="side-link <?= $active === 'browse' ? 'active' : '' ?>" href="index.php">⌕ <span>Browse items</span></a>
        <a class="side-link <?= $active === 'report' ? 'active' : '' ?>" href="report.php">＋ <span>Report lost / found</span></a>
        <?php if (loggedIn()): ?>
            <p class="side-heading space-top">MY ACCOUNT</p>
            <a class="side-link <?= $active === 'reports' ? 'active' : '' ?>" href="my-reports.php">▤ <span>My reports</span></a>
            <a class="side-link <?= $active === 'saved' ? 'active' : '' ?>" href="saved.php">♡ <span>Saved items</span></a>
            <a class="side-link <?= $active === 'inbox' ? 'active' : '' ?>" href="inbox.php">✉ <span>Messages</span>
                <?php $unread = messageCount(currentUser()); if ($unread > 0): ?><b class="number"><?= $unread ?></b><?php endif; ?>
            </a>
        <?php endif; ?>
        <div class="sidebar-bottom">
            <div class="tip-card"><span>✦</span><b>A little help matters.</b><p>One small clue can help someone find what they lost.</p></div>
            <?php if (loggedIn()): ?>
                <div class="profile"><div class="avatar"><?= strtoupper(substr(currentUser(), 0, 1)) ?></div><div><b><?= clean(currentUser()) ?></b><small>Member</small></div><a href="logout.php" title="Log out">↗</a></div>
            <?php else: ?>
                <a class="button full" href="login.php">Log in</a>
            <?php endif; ?>
        </div>
    </aside>
    <div class="main">
        <header class="topbar">
            <div><small>FINDORA COMMUNITY</small><h2><?= clean($pageTitle) ?></h2></div>
            <div class="top-right">
                <span><?= date("D, d M Y") ?></span>
                <?php if (loggedIn()): ?><a class="user-pill" href="my-reports.php"><span class="avatar mini"><?= strtoupper(substr(currentUser(), 0, 1)) ?></span><?= clean(currentUser()) ?></a>
                <?php else: ?><a class="button small-button" href="login.php">Log in</a><?php endif; ?>
            </div>
        </header>
        <main class="content">