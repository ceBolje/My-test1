<?php include 'header.php'; ?>

<?php empty($_SESSION['user_name']) ? include 'loginBlock.php' : ''; ?>


<?php if (!empty($_SESSION['user_name'])) { ?>
    <h1 class="page_title">Prizes</h1>

    <div class="home_actions text-left">
        <div class="row font-weight-bold">
            <div class="col-lg-1">Number</div>
            <div class="col-lg-4">Prize Title</div>
            <div class="col-lg-3">Status</div>
            <div class="col-lg-2">Date</div>
            <div class="col-lg-2">Actions</div>
        </div>

        <?php foreach($prizes as $prize) {
            
        }?>

        <div class="row text-muted">
            <div class="col-lg-1">1</div>
            <div class="col-lg-4">Money Prize 100 coins</div>
            <div class="col-lg-3">Transfered to bank account</div>
            <div class="col-lg-2">2018.05.05</div>
            <div class="col-lg-2">No available</div>
        </div>
        <div class="row text-muted">
            <div class="col-lg-1">2</div>
            <div class="col-lg-4">Bonus Points Prize 123 points</div>
            <div class="col-lg-3">Pending</div>
            <div class="col-lg-2">2018.05.05</div>
            <div class="col-lg-2">
                <div class="dropdown">
                    <a class="dropdown-toggle"
                       id="dropdownMenuButton"
                       data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">
                        Select action
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>