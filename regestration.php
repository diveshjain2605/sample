<?php
include('session.php');
include('header.php');
?>

<div class="container">
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Registration Form</span>
                    <form method="post" action="regestrationformsubmit.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="fname" id="fname" required>
                                <label for="fname">First Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <input type="text" name="lname" id="lname" required>
                                <label for="lname">Last Name</label>
                            </div>
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="email" id="email" required>
                                <label for="email">Email ID</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">account_circle</i>
                                <input type="text" name="username" id="username" required>
                                <label for="username">Username</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">lock</i>
                                <input type="password" name="password" id="password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="center-align">
                            <button type="submit" class="btn waves-effect waves-light green">
                                Register <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
