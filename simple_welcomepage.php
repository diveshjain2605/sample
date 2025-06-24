<?php
include('session.php');
include('conn.php');

// Get dashboard statistics
$userCount = 0;
$invoiceCount = 0;
$totalRevenue = 0;
$recentInvoices = [];

try {
    // Get user count
    $userResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM user");
    if ($userResult) {
        $userCount = mysqli_fetch_assoc($userResult)['count'];
    }
    
    // Get invoice count
    $invoiceResult = mysqli_query($conn, "SELECT COUNT(*) as count FROM invoice");
    if ($invoiceResult) {
        $invoiceCount = mysqli_fetch_assoc($invoiceResult)['count'];
    }
    
    // Get total revenue
    $revenueResult = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM invoice");
    if ($revenueResult) {
        $totalRevenue = mysqli_fetch_assoc($revenueResult)['total'] ?? 0;
    }
    
    // Get recent invoices
    $recentResult = mysqli_query($conn, "SELECT id, customer_name, total_amount, date FROM invoice ORDER BY date DESC LIMIT 5");
    if ($recentResult) {
        while ($row = mysqli_fetch_assoc($recentResult)) {
            $recentInvoices[] = $row;
        }
    }
} catch (Exception $e) {
    // Handle errors silently for demo
}

$page_title = 'Dashboard';
include('simple_header.php');
?>

<div class="page-content">
    <div class="container">
        <!-- Welcome Section -->
        <div class="welcome-section mb-8">
            <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</h1>
            <p>Here's what's happening with your warehouse today.</p>
        </div>
        
        <!-- Statistics Cards -->
        <div class="stats-grid mb-8">
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="material-icons">people</i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($userCount); ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="material-icons">receipt_long</i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo number_format($invoiceCount); ?></div>
                    <div class="stat-label">Total Invoices</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="material-icons">attach_money</i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">₹<?php echo number_format($totalRevenue, 0); ?></div>
                    <div class="stat-label">Total Revenue</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon info">
                    <i class="material-icons">trending_up</i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo date('M'); ?></div>
                    <div class="stat-label">Current Month</div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions mb-8">
            <h2>Quick Actions</h2>
            <div class="action-grid">
                <a href="invoice.php" class="action-card">
                    <div class="action-icon">
                        <i class="material-icons">add_box</i>
                    </div>
                    <div class="action-content">
                        <h3>Create Invoice</h3>
                        <p>Generate a new invoice for your customers</p>
                    </div>
                </a>
                
                <a href="Form.php" class="action-card">
                    <div class="action-icon">
                        <i class="material-icons">person_add</i>
                    </div>
                    <div class="action-content">
                        <h3>Add Customer</h3>
                        <p>Register a new customer in the system</p>
                    </div>
                </a>
                
                <a href="table.php" class="action-card">
                    <div class="action-icon">
                        <i class="material-icons">people</i>
                    </div>
                    <div class="action-content">
                        <h3>Manage Users</h3>
                        <p>View and manage system users</p>
                    </div>
                </a>
                
                <a href="invoicelist.php" class="action-card">
                    <div class="action-icon">
                        <i class="material-icons">list_alt</i>
                    </div>
                    <div class="action-content">
                        <h3>View Invoices</h3>
                        <p>Browse all invoices and their details</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="recent-activity">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recent Invoices</h2>
                    <a href="invoicelist.php" class="btn btn-secondary btn-sm">View All</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentInvoices)): ?>
                        <div class="invoice-list">
                            <?php foreach ($recentInvoices as $invoice): ?>
                                <div class="invoice-item">
                                    <div class="invoice-info">
                                        <div class="invoice-id">#<?php echo str_pad($invoice['id'], 4, '0', STR_PAD_LEFT); ?></div>
                                        <div class="invoice-customer"><?php echo htmlspecialchars($invoice['customer_name']); ?></div>
                                    </div>
                                    <div class="invoice-details">
                                        <div class="invoice-amount">₹<?php echo number_format($invoice['total_amount'], 2); ?></div>
                                        <div class="invoice-date"><?php echo date('M d, Y', strtotime($invoice['date'])); ?></div>
                                    </div>
                                    <div class="invoice-actions">
                                        <a href="itemlist.php?id=<?php echo $invoice['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="material-icons">receipt_long</i>
                            <h3>No invoices yet</h3>
                            <p>Create your first invoice to get started</p>
                            <a href="invoice.php" class="btn btn-primary">Create Invoice</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== DASHBOARD SPECIFIC STYLES ===== */
.welcome-section h1 {
    font-size: var(--font-size-3xl);
    font-weight: var(--font-bold);
    color: var(--text-primary);
    margin-bottom: var(--space-2);
}

.welcome-section p {
    font-size: var(--font-size-lg);
    color: var(--text-secondary);
    margin: 0;
}

/* ===== STATISTICS GRID ===== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-6);
}

.stat-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    display: flex;
    align-items: center;
    gap: var(--space-4);
    transition: all var(--transition-normal);
    box-shadow: var(--shadow-sm);
}

.stat-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: var(--radius-xl);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon.primary {
    background: var(--primary-100);
    color: var(--primary);
}

.stat-icon.success {
    background: var(--success-light);
    color: var(--success);
}

.stat-icon.warning {
    background: var(--warning-light);
    color: var(--warning);
}

.stat-icon.info {
    background: var(--info-light);
    color: var(--info);
}

.stat-icon .material-icons {
    font-size: 1.5rem;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: var(--font-size-2xl);
    font-weight: var(--font-bold);
    color: var(--text-primary);
    line-height: 1;
    margin-bottom: var(--space-1);
}

.stat-label {
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
    font-weight: var(--font-medium);
}

/* ===== QUICK ACTIONS ===== */
.quick-actions h2 {
    margin-bottom: var(--space-6);
}

.action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: var(--space-6);
}

.action-card {
    background: var(--bg-primary);
    border: 1px solid var(--border-light);
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    display: flex;
    align-items: flex-start;
    gap: var(--space-4);
    text-decoration: none;
    transition: all var(--transition-normal);
    box-shadow: var(--shadow-sm);
}

.action-card:hover {
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
    border-color: var(--primary);
}

.action-icon {
    width: 50px;
    height: 50px;
    background: var(--primary-100);
    color: var(--primary);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.action-icon .material-icons {
    font-size: 1.25rem;
}

.action-content h3 {
    font-size: var(--font-size-base);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    margin-bottom: var(--space-1);
}

.action-content p {
    font-size: var(--font-size-sm);
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.4;
}

/* ===== RECENT ACTIVITY ===== */
.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.invoice-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.invoice-item {
    display: flex;
    align-items: center;
    gap: var(--space-4);
    padding: var(--space-4);
    background: var(--bg-secondary);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
}

.invoice-item:hover {
    background: var(--bg-tertiary);
}

.invoice-info {
    flex: 1;
}

.invoice-id {
    font-size: var(--font-size-sm);
    font-weight: var(--font-semibold);
    color: var(--primary);
    margin-bottom: var(--space-1);
}

.invoice-customer {
    font-size: var(--font-size-sm);
    color: var(--text-primary);
    font-weight: var(--font-medium);
}

.invoice-details {
    text-align: right;
    margin-right: var(--space-4);
}

.invoice-amount {
    font-size: var(--font-size-base);
    font-weight: var(--font-semibold);
    color: var(--text-primary);
    margin-bottom: var(--space-1);
}

.invoice-date {
    font-size: var(--font-size-xs);
    color: var(--text-secondary);
}

.invoice-actions {
    flex-shrink: 0;
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: var(--space-12) var(--space-6);
}

.empty-state .material-icons {
    font-size: 4rem;
    color: var(--text-muted);
    margin-bottom: var(--space-4);
}

.empty-state h3 {
    font-size: var(--font-size-lg);
    color: var(--text-primary);
    margin-bottom: var(--space-2);
}

.empty-state p {
    color: var(--text-secondary);
    margin-bottom: var(--space-6);
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .action-grid {
        grid-template-columns: 1fr;
        gap: var(--space-4);
    }
    
    .stat-card,
    .action-card {
        padding: var(--space-4);
    }
    
    .invoice-item {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-3);
    }
    
    .invoice-details {
        text-align: left;
        margin-right: 0;
    }
    
    .card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-3);
    }
}
</style>

<?php include('simple_footer.php'); ?>
