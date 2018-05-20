<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Home page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          crossorigin="anonymous">
    <link rel="stylesheet" href="/tpl/css/style.css">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="/tpl/js/request.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container text-center">

    <?php if (!empty($_SESSION['user_name'])) { ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/game">Game</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/prizes">Prizes</a>
                    </li>
                    <li class="nav-link">Hi, <?php echo $_SESSION['user_name']; ?></li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/logout">Log out</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php } ?>
