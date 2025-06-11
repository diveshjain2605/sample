<?php
include('session.php');
if (isset($_SESSION['user_name'])) {
    header('Location: welcomepage.php');
    exit();
}
include('header.php');
?>

<div class="container">
    <div class="row" style="margin-top: 50px;">
        <div class="col s12 m8 offset-m2 l6 offset-l3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title center-align">Login</span>
                    <form method="post" action="login_check.php" enctype="multipart/form-data">
                        <div class="input-field">
                            <i class="material-icons prefix">person</i>
                            <input type="text" name="username" id="username" required>
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password" id="password" required>
                            <label for="password">Password</label>
                        </div>
                        <div class="center-align" style="margin-top: 20px;">
                            <button type="submit" class="btn waves-effect waves-light green">
                                Login <i class="material-icons right">send</i>
                            </button>
                        </div>
                        <div class="center-align" style="margin-top: 15px;">
                            <p>Don't have an account? <a href="regestration.php">Register here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
