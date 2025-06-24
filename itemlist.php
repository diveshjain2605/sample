<?php
include('session.php');
include('header.php');
include('navigation.php');
include('conn.php');

$id = $_GET['id'];

// First, check what columns exist in the invoice table
$invoice_columns_query = "SHOW COLUMNS FROM invoice";
$invoice_columns_result = mysqli_query($conn, $invoice_columns_query);
$available_columns = [];
while ($row = mysqli_fetch_assoc($invoice_columns_result)) {
    $available_columns[] = $row['Field'];
}

// Build the query based on available columns
$date_column = in_array('date', $available_columns) ? 'invoice.date' :
               (in_array('created_at', $available_columns) ? 'invoice.created_at' : 'NOW()');

$email_column = in_array('email', $available_columns) ? 'invoice.email' : "'' as email";

$rawQuery = "
SELECT invoice.customer_name,
       $date_column as date,
       $email_column,
       invoice_item.id,
       invoice_item.item_name,
       invoice_item.qty,
       invoice_item.mrp,
       invoice_item.total_price
FROM invoice_item
LEFT JOIN invoice ON invoice_item.invoice_id = invoice.id
WHERE invoice_item.invoice_id = $id";

$records = mysqli_query($conn, $rawQuery);

if (!$records) {
    echo "<div style='padding: 20px; text-align: center;'>";
    echo "<h3>Database Error</h3>";
    echo "<p>Query failed: " . mysqli_error($conn) . "</p>";
    echo "<p><a href='database_schema_fix.php' style='background: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Fix Database Schema</a></p>";
    echo "<p><a href='invoicelist.php' style='background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Back to Invoice List</a></p>";
    echo "</div>";
    exit();
}

$totalQuery = "
SELECT SUM(total_price) AS total_amount
FROM invoice_item
WHERE invoice_id = $id";
$totalResult = mysqli_query($conn, $totalQuery);
if (!$totalResult) {
    die('Query failed: ' . mysqli_error($conn));
}
$totalRow = mysqli_fetch_assoc($totalResult);
$totalAmount = $totalRow['total_amount'];

// Get customer info
$customerInfo = mysqli_fetch_assoc($records);
mysqli_data_seek($records, 0);
?>

<div class="container">
    <!-- Invoice Header -->
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text">
                    <div class="row">
                        <div class="col s12 m8">
                            <h4 style="margin: 0; color: white;">
                                <i class="material-icons left">receipt_long</i>
                                Invoice #<?php echo str_pad($id, 4, '0', STR_PAD_LEFT); ?>
                            </h4>
                            <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0;">
                                Generated on <?php echo date('F d, Y', strtotime($customerInfo['date'])); ?>
                            </p>
                        </div>
                        <div class="col s12 m4 right-align">
                            <div class="invoice-status">
                                <span class="status-badge-large paid">
                                    <i class="material-icons">check_circle</i> PAID
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Information Cards -->
    <div class="row">
        <div class="col s12 m6">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">person</i>
                        Customer Information
                    </span>
                    <div class="customer-details">
                        <div class="detail-item">
                            <strong>Customer Name:</strong>
                            <span><?php echo htmlspecialchars($customerInfo['customer_name']); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Invoice Date:</strong>
                            <span><?php echo date('F d, Y', strtotime($customerInfo['date'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Invoice ID:</strong>
                            <span class="invoice-id">#<?php echo str_pad($id, 4, '0', STR_PAD_LEFT); ?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Time:</strong>
                            <span><?php echo date('h:i A', strtotime($customerInfo['date'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m6">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">business</i>
                        Company Information
                    </span>
                    <div class="company-details">
                        <div class="company-logo">
                            <h5 style="color: var(--accent-light); margin-bottom: 15px;">Warehouse Pro</h5>
                        </div>
                        <div class="detail-item">
                            <strong>Address:</strong>
                            <span>123 Business Street<br>Tech City, TC 12345</span>
                        </div>
                        <div class="detail-item">
                            <strong>Phone:</strong>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="detail-item">
                            <strong>Email:</strong>
                            <span>info@warehousepro.com</span>
                        </div>
                        <div class="detail-item">
                            <strong>Website:</strong>
                            <span>www.warehousepro.com</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Items -->
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">shopping_cart</i>
                        Invoice Items
                    </span>

                    <div class="responsive-table-container" style="margin-top: 20px;">
                        <table class="striped responsive-table highlight">
                            <thead>
                                <tr>
                                    <th><i class="material-icons left tiny">tag</i>Item ID</th>
                                    <th><i class="material-icons left tiny">inventory</i>Item Name</th>
                                    <th><i class="material-icons left tiny">format_list_numbered</i>Quantity</th>
                                    <th><i class="material-icons left tiny">attach_money</i>Unit Price</th>
                                    <th><i class="material-icons left tiny">calculate</i>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $itemCount = 0;
                                while ($row = mysqli_fetch_assoc($records)) {
                                    $itemCount++;
                                ?>
                                <tr class="item-row">
                                    <td>
                                        <span class="item-badge">
                                            <?php echo str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="item-info">
                                            <strong><?php echo htmlspecialchars($row['item_name']); ?></strong>
                                            <br><small style="color: var(--text-secondary);">Item #<?php echo $itemCount; ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="quantity-badge">
                                            <?php echo $row['qty']; ?> pcs
                                        </span>
                                    </td>
                                    <td>
                                        <span class="price-text">
                                            ₹<?php echo number_format($row['mrp'], 2); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="total-price">
                                            ₹<?php echo number_format($row['total_price'], 2); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Invoice Summary -->
                    <div class="invoice-summary">
                        <div class="row">
                            <div class="col s12 m8">
                                <div class="summary-notes">
                                    <h6><i class="material-icons left tiny">note</i>Notes & Terms</h6>
                                    <p style="color: var(--text-secondary); font-size: 14px;">
                                        • Payment is due within 30 days of invoice date<br>
                                        • Late payments may incur additional charges<br>
                                        • All items are subject to our standard warranty terms
                                    </p>
                                </div>
                            </div>
                            <div class="col s12 m4">
                                <div class="summary-totals">
                                    <div class="summary-row">
                                        <span>Subtotal:</span>
                                        <span>₹<?php echo number_format($totalAmount, 2); ?></span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Tax (0%):</span>
                                        <span>₹0.00</span>
                                    </div>
                                    <div class="summary-row">
                                        <span>Discount:</span>
                                        <span>₹0.00</span>
                                    </div>
                                    <div class="divider" style="margin: 10px 0;"></div>
                                    <div class="summary-row total-row">
                                        <strong>Total Amount:</strong>
                                        <strong style="color: var(--accent-light); font-size: 18px;">
                                            ₹<?php echo number_format($totalAmount, 2); ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col s12 m6">
                            <div class="thank-you-message">
                                <h6 style="color: var(--accent-light); margin-bottom: 10px;">
                                    <i class="material-icons left tiny">favorite</i>Thank you for your business!
                                </h6>
                                <p style="color: var(--text-secondary); font-size: 14px;">
                                    We appreciate your trust in our services. For any queries, please contact our support team.
                                </p>
                            </div>
                        </div>
                        <div class="col s12 m6 right-align">
                            <div class="btn-group">
                                <a href="invoicelist.php" class="btn waves-effect waves-light btn-secondary tooltipped"
                                   data-tooltip="Back to Invoice List" data-position="top">
                                    <i class="material-icons left">arrow_back</i> Back to List
                                </a>
                                <a href="#" onclick="window.print()" class="btn waves-effect waves-light green tooltipped"
                                   data-tooltip="Print Invoice" data-position="top">
                                    <i class="material-icons left">print</i> Print
                                </a>
                                <a href="#" class="btn waves-effect waves-light orange tooltipped"
                                   data-tooltip="Download PDF" data-position="top">
                                    <i class="material-icons left">download</i> PDF
                                </a>
                                <a href="#" class="btn waves-effect waves-light red tooltipped"
                                   data-tooltip="Email Invoice" data-position="top">
                                    <i class="material-icons left">email</i> Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-badge-large {
    padding: 8px 16px;
    border-radius: 20px;
    color: white;
    font-size: 14px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.status-badge-large.paid {
    background: #4CAF50;
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.detail-item {
    margin-bottom: 15px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item strong {
    color: var(--text-secondary);
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.detail-item span {
    color: var(--text-primary);
    font-size: 16px;
}

.invoice-id {
    color: var(--accent-light) !important;
    font-weight: 600;
}

.company-logo h5 {
    font-weight: 600;
    text-shadow: 0 0 10px rgba(108, 92, 231, 0.3);
}

.item-row {
    transition: all 0.3s ease;
}

.item-row:hover {
    background: var(--glass-bg) !important;
}

.item-badge {
    background: var(--accent-light);
    color: white;
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
}

.quantity-badge {
    background: rgba(108, 92, 231, 0.1);
    color: var(--accent-light);
    padding: 4px 8px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 500;
}

.price-text, .total-price {
    font-family: 'Roboto Mono', monospace;
    font-weight: 500;
    color: var(--text-primary);
}

.total-price {
    color: var(--accent-light);
    font-weight: 600;
}

.invoice-summary {
    margin-top: 30px;
    padding: 20px;
    background: var(--glass-bg);
    border-radius: 10px;
    border: 1px solid var(--glass-border);
}

.summary-totals {
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 10px;
    border: 1px solid var(--glass-border);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: var(--text-primary);
}

.total-row {
    font-size: 16px;
    padding-top: 10px;
}

.action-buttons, .btn-group {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
    justify-content: flex-end;
}

.thank-you-message {
    padding: 10px 0;
}

@media (max-width: 768px) {
    .action-buttons, .btn-group {
        flex-direction: column;
        gap: 8px;
        justify-content: center;
    }

    .action-buttons .btn, .btn-group .btn {
        width: 100%;
        margin: 4px 0;
        justify-content: center;
    }

    .summary-totals {
        margin-top: 20px;
    }

    .right-align {
        text-align: center !important;
    }
}

/* Print styles */
@media print {
    nav, .action-buttons, .sidenav-trigger {
        display: none !important;
    }

    .container {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
    }
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

    // Animate items on load
    const itemRows = document.querySelectorAll('.item-row');
    itemRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';

        setTimeout(() => {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 150);
    });

    // Add click to copy invoice ID
    document.querySelector('.invoice-id').addEventListener('click', function() {
        navigator.clipboard.writeText(this.textContent).then(() => {
            M.toast({html: 'Invoice ID copied to clipboard!', classes: 'green'});
        });
    });
});
</script>

<?php include('footer.php'); ?>
