<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (session()->getFlashdata('error')): ?>
        <p><?= session()->getFlashdata('error') ?></p>
    <?php endif ?>
    <form action="/auth/authenticate" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= old('email') ?>" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>