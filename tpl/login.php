<?php include 'header.php'; ?>

    <h1 class="page_title">Log In</h1>

    <form action="/user/auth" method="POST">
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
        <a href="/">Home </a> or <a href="/user/signup">Sign Up</a>
    </div>


<?php include 'footer.php'; ?>