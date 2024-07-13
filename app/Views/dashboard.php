<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
<h1>Dashboard</h1>
<?php //echo "<pre>"; print_r($filteredUsers); exit; ?>
<a href="/profile">Profile update</a>
    <p>Welcome, <?= session()->get('name') ?>!</p>
    <a href="/auth/logout">Logout</a>

    <h2>All Users</h2>
    <ul>

        <?php foreach ($filteredUsers as $user): ?>
            <li><?= $user->name; ?> <a href="/dashboard/sendRequest/<?= $user->id ?>">Send Friend Request</a></li>
        <?php endforeach; ?>
    </ul>

    <h2>Friends</h2>
    <ul>
        <?php foreach ($friends as $friend): ?>
            <li><?= $friend['name'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Pending Friend Requests</h2>
    <ul>
        <?php foreach ($pendingRequests as $request): ?>
            <li><?= $request['name'] ?> <a href="/dashboard/acceptRequest/<?= $request['id'] ?>">Accept Request</a></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
