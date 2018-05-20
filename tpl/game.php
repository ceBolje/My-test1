<?php include 'header.php'; ?>

<?php empty($_SESSION['user_name']) ? include 'loginBlock.php' : ''; ?>

<?php if (!empty($_SESSION['user_name'])) { ?>
    <h1 class="page_title">Please, Press The Button</h1>
    <div class="page_actions">
        <button type="button" class="btn btn-outline-primary btn-lg">Get A Prize</button>
    </div>
<?php } ?>
    
    <!--    <h4 class="text-success">Congratulation, you won 234 coins! </h4>-->
    <!---->
    <!--    <a href="">Send money to bank account</a><br>-->
    <!--    <a href="">Change money to bonus points</a><br>-->
    <!---->
    <!--    <a href="">Put bonus points to my account</a><br>-->
    <!--    <a href="">Delivery the prize to my adress</a><br>-->
    <!---->
    <!--    <a href="">Refusal of a prize</a><br>-->
<?php include 'footer.php'; ?>