<?php include 'header.php'; ?>

<?php if (!empty($error)) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Holy guacamole!</strong> You should check in on some of those fields below.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>

    <h1 class="page_title">Sign Up</h1>

    <form action="/user/create" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="page_actions">
        <a href="/">Home </a> or <a href="/user/login">Log In</a>
    </div>

<?php include 'footer.php'; ?>