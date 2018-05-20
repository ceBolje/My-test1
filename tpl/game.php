<?php include 'header.php'; ?>

<?php empty($_SESSION['user_name']) ? include 'loginBlock.php' : ''; ?>

<?php if (!empty($_SESSION['user_name'])) { ?>

    <h1 class="page_title">Please, Press The Button</h1>
    <div class="page_actions">
        <button type="button" class="btn btn-outline-primary btn-lg" data-handler="onGetPrize">Get A Prize</button>
    </div>
    
<?php } ?>

    <div id="loader" class="text-center d-none">
        <img src="/tpl/img/loader.gif" />
    </div>

<?php include 'prizesActions.php'; ?>
<?php include 'footer.php'; ?>