<!DOCTYPE html>
<html>
<head>
    <title>Friends</title>
</head>
<body>
    <h2>Friends List</h2>
    <ul>
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/profile">Profile</a></li>
        <li><a href="/friends">Friends</a></li>
        <li><a href="/auth/logout">Logout</a></li>
    </ul>
    <ul>
        <?php foreach ($friends as $friend): ?>
            <li><?= esc($friend['name']) ?> (<?= esc($friend['email']) ?>)</li>
        <?php endforeach ?>
    </ul>
</body>
</html>
