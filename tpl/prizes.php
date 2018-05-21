<?php include 'header.php'; ?>

<?php empty($_SESSION['user_name']) ? include 'loginBlock.php' : ''; ?>


<?php if (!empty($_SESSION['user_name'])) { ?>
    <h1 class="page_title">Prizes</h1>

    <div class="home_actions text-left">
        <div class="row font-weight-bold">
            <div class="col-lg-1">ID</div>
            <div class="col-lg-3">Prize Title</div>
            <div class="col-lg-2">Prize Amount</div>
            <div class="col-lg-1">Status</div>
            <div class="col-lg-1">Details</div>
            <div class="col-lg-2">Date</div>
            <div class="col-lg-2 text-right">Actions</div>
        </div>

        <?php foreach ($prizes as $prize) { ?>

            <div class="row text-muted strip">
                <div class="col-lg-1"><?php echo $prize['id']; ?></div>
                <div class="col-lg-3"><?php echo $prize['name'] . ' ' . $prize['goodsName'] ?? ''; ?></div>
                <div class="col-lg-2"><?php echo $prize['amount']; ?></div>
                <div class="col-lg-1"><?php echo $prize['status']; ?></div>
                <div class="col-lg-1"><?php echo $prize['processed_type']; ?></div>
                <div class="col-lg-2"><?php echo $prize['date']; ?></div>
                <div class="col-lg-2  text-right">

                    <?php if ($prize['status'] == 'new') { ?>
                        <div class="dropdown">
                            <a class="dropdown-toggle"
                               id="dropdownMenuButton"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                Action
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <?php if ($prize['type'] == 'money') { ?>
                                    <a class="dropdown-item" href="/prizes/tobank/<?php echo $prize['id']; ?>">
                                        Transfer to Bank Account
                                    </a>
                                    <a class="dropdown-item" href="/prizes/moneytopoints/<?php echo $prize['id']; ?>">
                                        Transfer to Points
                                    </a>
                                <?php } ?>

                                <?php if ($prize['type'] == 'points') { ?>
                                    <a class="dropdown-item" href="/prizes/toaccount/<?php echo $prize['id']; ?>">
                                        Put Points To Account
                                    </a>
                                <?php } ?>

                                <?php if ($prize['type'] == 'goods') { ?>
                                    <a class="dropdown-item" href="/prizes/delivery/<?php echo $prize['id']; ?>">
                                        Delivery to Mail Address
                                    </a>
                                <?php } ?>

                                <a class="dropdown-item" href="/prizes/refusal/<?php echo $prize['id']; ?>">Refusal of
                                    this prize</a>
                            </div>

                        </div>
                    <?php } else { ?>
                        No available
                    <?php } ?>

                </div>
            </div>
        <?php } ?>

    </div>
<?php } ?>
<?php include 'footer.php'; ?>
