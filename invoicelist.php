<?php
include('session.php');
include('header.php');
include('navigation.php');
include('conn.php');

$start = @$_GET['start'] ?? 0;
$end = @$_GET['end'] ?? 10;
$search = @$_GET['search'] ?? '';

// Check what columns exist in the invoice table
$invoice_columns_query = "SHOW COLUMNS FROM invoice";
$invoice_columns_result = mysqli_query($conn, $invoice_columns_query);
$available_columns = [];
while ($row = mysqli_fetch_assoc($invoice_columns_result)) {
    $available_columns[] = $row['Field'];
}

// Build the query based on available columns
$date_column = in_array('date', $available_columns) ? 'invoice.date' :
               (in_array('created_at', $available_columns) ? 'invoice.created_at' : 'NOW()');

$status_column = in_array('status', $available_columns) ? 'invoice.status' : "'pending' as status";

$totalamountQuery = "
SELECT
invoice.id,
invoice.customer_name,
$date_column as date,
$status_column,
COALESCE(SUM(invoice_item.total_price), 0) AS total_amount
FROM invoice
LEFT JOIN invoice_item ON invoice_item.invoice_id = invoice.id
WHERE customer_name LIKE '%".$search."%'
GROUP BY
invoice.id, invoice.customer_name, $date_column
ORDER BY invoice.id DESC
LIMIT $start,$end
";

$records = mysqli_query($conn, $totalamountQuery);
if (!$records) {
    echo "<div style='padding: 20px; text-align: center;'>";
    echo "<h3>Database Error</h3>";
    echo "<p>Query failed: " . mysqli_error($conn) . "</p>";
    echo "<p><a href='database_schema_fix.php' style='background: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Fix Database Schema</a></p>";
    echo "<p><a href='welcomepage.php' style='background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Back to Dashboard</a></p>";
    echo "</div>";
    exit();
}

// Count total records for pagination
$countQuery = "SELECT COUNT(DISTINCT invoice.id) as total FROM invoice
               WHERE customer_name LIKE '%".$search."%'";
$countResult = mysqli_query($conn, $countQuery);
if ($countResult) {
    $totalRecords = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($totalRecords / 10);
} else {
    $totalRecords = 0;
    $totalPages = 0;
}
?>

<div class="container">
    <!-- Header Section -->
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text center-align">
                    <i class="material-icons large">receipt_long</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">Invoice Management</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Track and manage all customer invoices</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Actions -->
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m8">
                            <form action="invoicelist.php" method="GET" class="row" style="margin-bottom: 0;">
                                <div class="input-field col s12 m8">
                                    <i class="material-icons prefix">search</i>
                                    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>">
                                    <label for="search">Search by customer name</label>
                                </div>
                                <div class="col s12 m4" style="margin-top: 20px; display: flex; gap: 10px; align-items: center;">
                                    <button type="submit" class="btn waves-effect waves-light" style="flex: 1; min-width: 100px;">
                                        <i class="material-icons left">search</i>SEARCH
                                    </button>
                                    <a href="invoicelist.php" class="btn-secondary btn waves-effect waves-light" style="flex: 1; min-width: 100px;">
                                        <i class="material-icons left">clear</i>CLEAR
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col s12 m4 right-align" style="margin-top: 20px;">
                            <a href="invoice.php" class="btn waves-effect waves-light">
                                <i class="material-icons left">add</i>Create Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Statistics -->
    <div class="row">
        <div class="col s12 m3">
            <div class="card hoverable center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">receipt</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;"><?php echo $totalRecords; ?></h4>
                    <p>Total Invoices</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card hoverable center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">today</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">
                        <?php
                        $todayQuery = "SELECT COUNT(*) as today_count FROM invoice WHERE DATE(date) = CURDATE()";
                        $todayResult = mysqli_query($conn, $todayQuery);
                        echo mysqli_fetch_assoc($todayResult)['today_count'];
                        ?>
                    </h4>
                    <p>Today's Invoices</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card hoverable center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">trending_up</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">
                        <?php
                        $monthQuery = "SELECT COUNT(*) as month_count FROM invoice WHERE MONTH(date) = MONTH(CURDATE()) AND YEAR(date) = YEAR(CURDATE())";
                        $monthResult = mysqli_query($conn, $monthQuery);
                        echo mysqli_fetch_assoc($monthResult)['month_count'];
                        ?>
                    </h4>
                    <p>This Month</p>
                </div>
            </div>
        </div>
        <div class="col s12 m3">
            <div class="card hoverable center-align">
                <div class="card-content">
                    <i class="material-icons large" style="color: var(--accent-light);">account_balance_wallet</i>
                    <h4 style="color: var(--accent-light); margin: 10px 0;">
                        ₹<?php
                        $totalAmountQuery = "SELECT SUM(invoice_item.total_price) as total_revenue FROM invoice_item";
                        $totalAmountResult = mysqli_query($conn, $totalAmountQuery);
                        $totalRevenue = mysqli_fetch_assoc($totalAmountResult)['total_revenue'];
                        echo number_format($totalRevenue ?? 0, 0);
                        ?>
                    </h4>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoices Table -->
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left">list</i>Invoice Records
                        <span class="right" style="font-size: 14px; color: var(--text-secondary);">
                            Showing <?php echo min($end, $totalRecords); ?> of <?php echo $totalRecords; ?> invoices
                        </span>
                    </span>

                    <div class="responsive-table-container" style="margin-top: 20px;">
                        <table class="responsive-table highlight">
                            <thead>
                                <tr>
                                    <th><i class="material-icons left tiny">tag</i>Invoice ID</th>
                                    <th><i class="material-icons left tiny">person</i>Customer</th>
                                    <th><i class="material-icons left tiny">date_range</i>Date</th>
                                    <th><i class="material-icons left tiny">attach_money</i>Amount</th>
                                    <th><i class="material-icons left tiny">info</i>Status</th>
                                    <th><i class="material-icons left tiny">settings</i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($records) > 0) {
                                    while ($row = mysqli_fetch_assoc($records)) {
                                        $statusColor = 'green';
                                        $statusText = 'Paid';
                                        $statusIcon = 'check_circle';
                                ?>
                                <tr class="invoice-row" data-invoice-id="<?php echo $row['id']; ?>">
                                    <td>
                                        <span class="badge" style="background: var(--accent-light) !important; color: white !important;">
                                            #<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="customer-info">
                                            <strong><?php echo htmlspecialchars($row['customer_name']); ?></strong>
                                            <br><small style="color: var(--text-secondary);">Customer</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="date-text">
                                            <?php echo isset($row['date']) ? date('M d, Y', strtotime($row['date'])) : 'N/A'; ?>
                                        </span>
                                        <br><small style="color: var(--text-secondary);">
                                            <?php echo isset($row['date']) ? date('h:i A', strtotime($row['date'])) : ''; ?>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="amount-text" style="color: var(--accent-light); font-weight: 600; font-size: 16px;">
                                            <?php echo isset($row['total_amount']) ? '₹'.number_format($row['total_amount'], 2) : 'N/A'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge <?php echo $statusColor; ?>">
                                            <i class="material-icons tiny"><?php echo $statusIcon; ?></i>
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="itemlist.php?id=<?php echo $row['id']; ?>"
                                               class="btn-small waves-effect waves-light tooltipped"
                                               data-tooltip="View Invoice" data-position="top">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="#" class="btn-small waves-effect waves-light orange tooltipped"
                                               data-tooltip="Edit Invoice" data-position="top">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#" class="btn-small waves-effect waves-light green tooltipped"
                                               data-tooltip="Download PDF" data-position="top">
                                                <i class="material-icons">download</i>
                                            </a>
                                            <a href="#" class="btn-small waves-effect waves-light red tooltipped delete-invoice"
                                               data-tooltip="Delete Invoice" data-position="top" data-invoice-id="<?php echo $row['id']; ?>">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="center-align" style="padding: 40px;">
                                            <i class="material-icons large" style="color: var(--text-secondary);">receipt_long</i>
                                            <p style="color: var(--text-secondary); margin-top: 20px;">No invoices found</p>
                                            <a href="invoice.php" class="btn waves-effect waves-light" style="margin-top: 15px;">
                                                <i class="material-icons left">add</i>Create First Invoice
                                            </a>
                                          </td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1) { ?>
                <div class="card-action">
                    <ul class="pagination center-align">
                        <li class="<?php echo ($start <= 0) ? 'disabled' : 'waves-effect'; ?>">
                            <a href="<?php echo ($start <= 0) ? '#' : 'invoicelist.php?start='.($start-10).'&end='.$end.'&search='.urlencode($search); ?>">
                                <i class="material-icons">chevron_left</i>
                            </a>
                        </li>

                        <?php
                        for($i = 0; $i < $totalPages; $i++) {
                            $pageStart = $i * 10;
                            $pageEnd = $pageStart + 10;
                            $active = ($pageStart == $start) ? 'active' : 'waves-effect';
                        ?>
                            <li class="<?php echo $active; ?>">
                                <a href="invoicelist.php?start=<?php echo $pageStart; ?>&end=<?php echo $pageEnd; ?>&search=<?php echo urlencode($search); ?>">
                                    <?php echo ($i + 1); ?>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="<?php echo ($start >= ($totalPages-1)*10) ? 'disabled' : 'waves-effect'; ?>">
                            <a href="<?php echo ($start >= ($totalPages-1)*10) ? '#' : 'invoicelist.php?start='.($start+10).'&end='.$end.'&search='.urlencode($search); ?>">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<style>
.invoice-row {
    transition: all 0.3s ease;
}

.invoice-row:hover {
    background: var(--glass-bg) !important;
    transform: translateX(5px);
}

.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
}

.action-buttons .btn-small {
    padding: 0 12px;
    height: 36px;
    line-height: 36px;
    border-radius: 18px;
    min-width: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.badge {
    padding: 6px 12px;
    border-radius: 12px;
    color: white !important;
    font-size: 13px;
    font-weight: 600;
    background-color: var(--accent-light) !important;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    text-align: center;
}

.customer-info strong {
    color: var(--text-primary);
}

.amount-text {
    font-family: 'Roboto Mono', monospace;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    color: white;
    font-size: 11px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.status-badge.green {
    background: #4CAF50;
}

.status-badge.orange {
    background: #FF9800;
}

.status-badge.red {
    background: #f44336;
}

.responsive-table-container {
    overflow-x: auto;
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        gap: 2px;
    }

    .action-buttons .btn-small {
        width: 100%;
        margin: 1px 0;
    }
}

/* Remove striped background and create consistent row styling */
table tbody tr {
    background-color: var(--glass-bg) !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

table tbody tr:hover {
    background-color: rgba(108, 92, 231, 0.1) !important;
    transform: translateX(5px);
}

/* Ensure no alternating colors - override any striped styling */
table.striped tbody tr:nth-child(odd),
table.striped tbody tr:nth-child(even),
table tbody tr:nth-child(odd),
table tbody tr:nth-child(even) {
    background-color: var(--glass-bg) !important;
}

table.striped tbody tr:nth-child(odd):hover,
table.striped tbody tr:nth-child(even):hover,
table tbody tr:nth-child(odd):hover,
table tbody tr:nth-child(even):hover {
    background-color: rgba(108, 92, 231, 0.1) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips);

    // Initialize sidenav
    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs);

    // Delete invoice confirmation
    document.querySelectorAll('.delete-invoice').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const invoiceId = this.getAttribute('data-invoice-id');

            if (confirm('Are you sure you want to delete this invoice? This action cannot be undone.')) {
                // Here you would implement the delete functionality
                console.log('Delete invoice with ID:', invoiceId);
                // You can add AJAX call here to delete the invoice
            }
        });
    });

    // Animate rows on load
    const rows = document.querySelectorAll('.invoice-row');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';

        setTimeout(() => {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Animate statistics cards
    const statCards = document.querySelectorAll('.card h4');
    statCards.forEach((card, index) => {
        const targetValue = parseInt(card.textContent.replace(/[^\d]/g, ''));
        if (!isNaN(targetValue)) {
            animateCounter(card, targetValue, 1500);
        }
    });

    function animateCounter(element, target, duration) {
        const increment = target / (duration / 50);
        let current = 0;

        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            const originalText = element.textContent;
            if (originalText.includes('₹')) {
                element.textContent = '₹' + Math.floor(current).toLocaleString();
            } else {
                element.textContent = Math.floor(current).toString();
            }
        }, 50);
    }
});
</script>

<?php include('footer.php'); ?>


