<!-- Footer -->
<footer class="page-footer">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">Warehouse Pro</h5>
                <p class="grey-text text-lighten-4">
                    Professional warehouse management system for modern businesses.
                    Streamline your operations with our comprehensive invoice and customer management tools.
                </p>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Quick Links</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="welcomepage.php">
                        <i class="material-icons left tiny">dashboard</i>Dashboard
                    </a></li>
                    <li><a class="grey-text text-lighten-3" href="invoice.php">
                        <i class="material-icons left tiny">add</i>Create Invoice
                    </a></li>
                    <li><a class="grey-text text-lighten-3" href="invoicelist.php">
                        <i class="material-icons left tiny">list</i>View Invoices
                    </a></li>
                    <li><a class="grey-text text-lighten-3" href="table.php">
                        <i class="material-icons left tiny">people</i>Manage Users
                    </a></li>
                </ul>
            </div>
            <div class="col l3 s12">
                <h5 class="white-text">Support</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#help">
                        <i class="material-icons left tiny">help</i>Help Center
                    </a></li>
                    <li><a class="grey-text text-lighten-3" href="#contact">
                        <i class="material-icons left tiny">email</i>Contact Support
                    </a></li>
                    <li><a class="grey-text text-lighten-3" href="profile.php">
                        <i class="material-icons left tiny">settings</i>Account Settings
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row">
                <div class="col s12 m6">
                    © <?php echo date('Y'); ?> Warehouse Pro. All rights reserved.
                </div>
                <div class="col s12 m6 right-align">
                    <span class="grey-text text-lighten-4">
                        Version 2.0 |
                        <a class="grey-text text-lighten-3" href="#privacy">Privacy Policy</a> |
                        <a class="grey-text text-lighten-3" href="#terms">Terms of Service</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect waves-light" id="backToTop" style="display: none;">
        <i class="large material-icons">keyboard_arrow_up</i>
    </a>
</div>

<style>
.page-footer {
    background: linear-gradient(135deg, var(--primary-dark), var(--secondary-dark));
    margin-top: 50px;
    padding-top: 40px;
}

.page-footer .footer-copyright {
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(10px);
}

.page-footer h5 {
    color: var(--accent-light) !important;
    font-weight: 500;
}

.page-footer ul li a {
    transition: all 0.3s ease;
    padding: 5px 0;
    display: block;
}

.page-footer ul li a:hover {
    color: var(--accent-light) !important;
    padding-left: 10px;
}

.fixed-action-btn {
    bottom: 45px;
    right: 24px;
}

.fixed-action-btn .btn-floating {
    background: linear-gradient(135deg, var(--accent-purple), var(--accent-light));
    transition: all 0.3s ease;
}

.fixed-action-btn .btn-floating:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
}

/* Responsive footer */
@media only screen and (max-width: 992px) {
    .page-footer .container .row .col {
        margin-bottom: 20px;
    }

    .footer-copyright .right-align {
        text-align: left !important;
    }
}
</style>

    <!-- Material Design JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- UI Enhancements JavaScript -->
    <script src="ui_enhancements.js"></script>
    <script>
        // Initialize Material Design components
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dropdowns
            var dropdowns = document.querySelectorAll('.dropdown-trigger');
            M.Dropdown.init(dropdowns);

            // Initialize selects
            var selects = document.querySelectorAll('select');
            M.FormSelect.init(selects);

            // Initialize modals
            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);

            // Back to top functionality
            const backToTopBtn = document.getElementById('backToTop');

            if (backToTopBtn) {
                window.addEventListener('scroll', function() {
                    if (window.pageYOffset > 300) {
                        backToTopBtn.style.display = 'block';
                        backToTopBtn.style.opacity = '1';
                    } else {
                        backToTopBtn.style.display = 'none';
                        backToTopBtn.style.opacity = '0';
                    }
                });

                backToTopBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // Initialize floating action button
            var elems = document.querySelectorAll('.fixed-action-btn');
            M.FloatingActionButton.init(elems);
        });
    </script>
</body>
</html>