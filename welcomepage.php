<?php
include('session.php');
if (!(isset($_SESSION['user_name']))) {
    header('Location: index.php');
    exit();
}
include('header.php');
?>

<nav>
    <div class="nav-wrapper green">
        <a href="#" class="brand-logo">Dashboard</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="welcomepage.php"><i class="material-icons left">home</i>Home</a></li>
            <li><a href="Form.php"><i class="material-icons left">contact_mail</i>Contact</a></li>
            <li><a href="invoicelist.php"><i class="material-icons left">receipt</i>Invoices</a></li>
            <li><a href="logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
            <li><a class="dropdown-trigger" href="#" data-target="dropdown1">
                <i class="material-icons left">person</i><?php echo $_SESSION['user_name']; ?><i class="material-icons right">arrow_drop_down</i>
            </a></li>
        </ul>
    </div>
</nav>

<ul id="dropdown1" class="dropdown-content">
    <li><a href="#!">Profile</a></li>
    <li><a href="#!">Settings</a></li>
    <li class="divider"></li>
    <li><a href="logout.php">Logout</a></li>
</ul>

<div class="container">
    <div class="row" style="margin-top: 30px;">
        <div class="col s12 m4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Users</span>
                    <p>Manage registered users</p>
                </div>
                <div class="card-action">
                    <a href="table.php">View Users</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Invoices</span>
                    <p>Manage customer invoices</p>
                </div>
                <div class="card-action">
                    <a href="invoice.php">Create Invoice</a>
                    <a href="invoicelist.php">View Invoices</a>
                </div>
            </div>
        </div>
        <div class="col s12 m4">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Forms</span>
                    <p>Manage customer information</p>
                </div>
                <div class="card-action">
                    <a href="Form.php">Customer Form</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
