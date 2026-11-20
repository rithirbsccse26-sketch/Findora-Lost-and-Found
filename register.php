<?php
require "config.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $users = readData("users.json");
    $exists = false;
    foreach ($users as $user) if (strtolower($user["username"]) === strtolower($name)) $exists = true;
    if ($name === "" || strlen($password) < 5) $error = "Choose a username and a password with at least 5 characters.";
    elseif ($exists) $error = "That username is already in use.";
    else {
        $users[] = ["username" => $name, "password" => password_hash($password, PASSWORD_DEFAULT)];
        saveData("users.json", $users);
        $_SESSION["user"] = $name;
        header("Location: dashboard.php");
        exit;
    }
}
$pageTitle = "Create account";
require "header.php";
?>
<div class="auth-card"><span class="eyebrow">JOIN THE COMMUNITY</span><h1>Let's get started.</h1><p class="muted">Create an account to post reports and contact other members.</p>
<?php if ($error): ?><div class="error"><?= clean($error) ?></div><?php endif; ?>
<form method="POST" class="form">
    <label>Username<input name="username" required></label>
    <label>Password<input type="password" name="password" required></label>
    <button class="button full" type="submit">Create account</button>
</form>
<p class="auth-foot">Already registered? <a href="login.php">Log in</a></p></div>
<?php require "footer.php"; ?>