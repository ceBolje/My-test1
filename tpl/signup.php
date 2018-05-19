<?php include 'header.php'; ?>

    <h1 class="page_title">Sign Up</h1>

    <form action="/user/create" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="name" class="form-control" id="name" placeholder="Enter name">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


<?php include 'footer.php'; ?>