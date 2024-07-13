<!DOCTYPE html>
<html>
<head>
    <title>dashbaord</title>
    <link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
<body>
    <div class="left-menu">
        <ul>
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/profile">Profile</a></li>
            <li><a href="/friends">Friends</a></li>
            <li><a href="/auth/logout">Logout</a></li>
        </ul>
    </div>
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>
