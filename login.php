<?php
require "config.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    foreach (readData("users.json") as $user) {
        if (strtolower($user["username"]) === strtolower($name) && password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user["username"];
            header("Location: dashboard.php");
            exit;
        }
    }
    $error = "Username or password is incorrect.";
}
$pageTitle = "Log in";
require "header.php";
?>
<div class="auth-card"><span class="eyebrow">WELCOME BACK</span><h1>Good to see you.</h1><p class="muted">Log in to manage your reports and messages.</p>
<?php if ($error): ?><div class="error"><?= clean($error) ?></div><?php endif; ?>
<form method="POST" class="form">
    <label>Username<input name="username" required></label>
    <label>Password<input type="password" name="password" required></label>
    <button class="button full" type="submit">Log in</button>
</form>
<p class="auth-foot">New to Findora? <a href="register.php">Create an account</a></p></div>
<?php require "footer.php"; ?>