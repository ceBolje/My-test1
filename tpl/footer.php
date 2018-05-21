</div>
<?php if (!empty($_SESSION['user_name'])) { ?>
    <footer><span class="text-muted">Prizes can be processed later. All your prizes <a href="/prizes">here</a></span>
    </footer>
<?php } ?>
<div class="myalert alert alert-success alert-dismissible d-none" role="alert">
    <span id="message"></span>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
</body>
</html>