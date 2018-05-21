<?php include 'header.php'; ?>

    <h1 class="page_title">Get one of available prize:</h1>
    <ul class="prize_list">
        <?php
        if (!empty($goods)) {
            foreach ($goods as $good) {
                echo '<li> ' . $good['number'] . ' ' . $good['name'] . ' </li>';
            }
        }
        if (!empty($money)) {
            echo '<li> to ' . $money['amount'] . ' coins of money </li>';
        }

        ?>
        <li>unlimited bonus points</li>
    </ul>

    <div class="page_actions">
        <?php if (!empty($_SESSION['user_name'])) { ?>
            <a href="/prizes/game">Go ahead</a>
        <?php } else { ?>
            <a href="/user/login">Log In </a> or <a href="/user/signup">Sign Up</a>
        <?php } ?>
    </div>

<?php include 'footer.php'; ?>