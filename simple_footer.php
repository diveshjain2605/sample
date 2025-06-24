    </div> <!-- End page content -->
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-brand">
                        <i class="material-icons">inventory_2</i>
                        <span>Warehouse Pro</span>
                    </div>
                    <p class="footer-description">
                        Modern warehouse management system for efficient inventory and invoice management.
                    </p>
                </div>
                
                <div class="footer-section">
                    <h6 class="footer-title">Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="welcomepage.php">Dashboard</a></li>
                        <li><a href="table.php">Users</a></li>
                        <li><a href="invoicelist.php">Invoices</a></li>
                        <li><a href="Form.php">Add Customer</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h6 class="footer-title">Account</h6>
                    <ul class="footer-links">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="change_password.php">Change Password</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h6 class="footer-title">System Info</h6>
                    <div class="system-stats">
                        <div class="stat-item">
                            <i class="material-icons">people</i>
                            <span>
                                <?php
                                if (isset($conn)) {
                                    $userCount = mysqli_query($conn, "SELECT COUNT(*) as count FROM user");
                                    echo mysqli_fetch_assoc($userCount)['count'] ?? '0';
                                } else {
                                    echo '0';
                                }
                                ?> Users
                            </span>
                        </div>
                        <div class="stat-item">
                            <i class="material-icons">receipt</i>
                            <span>
                                <?php
                                if (isset($conn)) {
                                    $invoiceCount = mysqli_query($conn, "SELECT COUNT(*) as count FROM invoice");
                                    echo mysqli_fetch_assoc($invoiceCount)['count'] ?? '0';
                                } else {
                                    echo '0';
                                }
                                ?> Invoices
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> Warehouse Pro. All rights reserved.</p>
                    <div class="footer-actions">
                        <button class="back-to-top" onclick="scrollToTop()" title="Back to top">
                            <i class="material-icons">keyboard_arrow_up</i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <style>
        /* ===== FOOTER STYLES ===== */
        .footer {
            background: var(--bg-primary);
            border-top: 1px solid var(--border-light);
            margin-top: var(--space-12);
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-8);
            padding: var(--space-12) 0 var(--space-8);
        }
        
        .footer-section {
            display: flex;
            flex-direction: column;
            gap: var(--space-4);
        }
        
        .footer-brand {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: var(--font-size-lg);
            font-weight: var(--font-bold);
            color: var(--primary);
            margin-bottom: var(--space-2);
        }
        
        .footer-brand .material-icons {
            font-size: 1.5rem;
        }
        
        .footer-description {
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
            line-height: 1.6;
            margin: 0;
        }
        
        .footer-title {
            font-size: var(--font-size-base);
            font-weight: var(--font-semibold);
            color: var(--text-primary);
            margin-bottom: var(--space-3);
        }
        
        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: var(--space-2);
        }
        
        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: var(--font-size-sm);
            transition: color var(--transition-fast);
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .system-stats {
            display: flex;
            flex-direction: column;
            gap: var(--space-3);
        }
        
        .stat-item {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
        }
        
        .stat-item .material-icons {
            font-size: 1.125rem;
            color: var(--primary);
        }
        
        .footer-bottom {
            border-top: 1px solid var(--border-light);
            padding: var(--space-6) 0;
        }
        
        .footer-bottom-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: var(--space-4);
        }
        
        .footer-bottom p {
            color: var(--text-muted);
            font-size: var(--font-size-sm);
            margin: 0;
        }
        
        .footer-actions {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }
        
        .back-to-top {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: var(--primary);
            color: var(--text-inverse);
            border: none;
            border-radius: 50%;
            cursor: pointer;
            transition: all var(--transition-fast);
            box-shadow: var(--shadow-md);
        }
        
        .back-to-top:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .back-to-top .material-icons {
            font-size: 1.25rem;
        }
        
        /* ===== RESPONSIVE FOOTER ===== */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                gap: var(--space-6);
                padding: var(--space-8) 0 var(--space-6);
            }
            
            .footer-bottom-content {
                flex-direction: column;
                text-align: center;
                gap: var(--space-3);
            }
            
            .system-stats {
                flex-direction: row;
                justify-content: space-around;
            }
        }
        
        /* ===== SCROLL BEHAVIOR ===== */
        html {
            scroll-behavior: smooth;
        }
        
        /* ===== LOADING STATES ===== */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* ===== NOTIFICATION STYLES ===== */
        .notification {
            position: fixed;
            top: var(--space-6);
            right: var(--space-6);
            background: var(--bg-primary);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            padding: var(--space-4);
            max-width: 400px;
            z-index: var(--z-tooltip);
            transform: translateX(100%);
            transition: transform var(--transition-normal);
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            border-left: 4px solid var(--success);
        }
        
        .notification.error {
            border-left: 4px solid var(--error);
        }
        
        .notification.warning {
            border-left: 4px solid var(--warning);
        }
        
        .notification.info {
            border-left: 4px solid var(--info);
        }
        
        .notification-content {
            display: flex;
            align-items: flex-start;
            gap: var(--space-3);
        }
        
        .notification-icon {
            color: var(--primary);
            margin-top: 2px;
        }
        
        .notification-text {
            flex: 1;
        }
        
        .notification-title {
            font-weight: var(--font-semibold);
            color: var(--text-primary);
            margin-bottom: var(--space-1);
        }
        
        .notification-message {
            color: var(--text-secondary);
            font-size: var(--font-size-sm);
            margin: 0;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            margin-left: var(--space-2);
        }
        
        .notification-close:hover {
            color: var(--text-primary);
        }
    </style>
    
    <script>
        // Back to top functionality
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
        
        // Show/hide back to top button based on scroll position
        window.addEventListener('scroll', function() {
            const backToTop = document.querySelector('.back-to-top');
            if (window.pageYOffset > 300) {
                backToTop.style.opacity = '1';
                backToTop.style.visibility = 'visible';
            } else {
                backToTop.style.opacity = '0';
                backToTop.style.visibility = 'hidden';
            }
        });
        
        // Notification system
        function showNotification(title, message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="material-icons notification-icon">${getNotificationIcon(type)}</i>
                    <div class="notification-text">
                        <div class="notification-title">${title}</div>
                        <p class="notification-message">${message}</p>
                    </div>
                    <button class="notification-close" onclick="closeNotification(this)">
                        <i class="material-icons">close</i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Show notification
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto-hide after 5 seconds
            setTimeout(() => {
                closeNotification(notification.querySelector('.notification-close'));
            }, 5000);
        }
        
        function getNotificationIcon(type) {
            switch(type) {
                case 'success': return 'check_circle';
                case 'error': return 'error';
                case 'warning': return 'warning';
                case 'info': 
                default: return 'info';
            }
        }
        
        function closeNotification(button) {
            const notification = button.closest('.notification');
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
        
        // Form loading states
        function setFormLoading(form, loading = true) {
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton) {
                if (loading) {
                    submitButton.classList.add('loading');
                    submitButton.disabled = true;
                    submitButton.dataset.originalText = submitButton.textContent;
                    submitButton.textContent = 'Loading...';
                } else {
                    submitButton.classList.remove('loading');
                    submitButton.disabled = false;
                    submitButton.textContent = submitButton.dataset.originalText || 'Submit';
                }
            }
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
        
        // Initialize tooltips and other components
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation to page content
            const pageContent = document.querySelector('.page-content');
            if (pageContent) {
                pageContent.classList.add('fade-in-up');
            }
            
            // Initialize any additional components here
        });
    </script>
</body>
</html>
