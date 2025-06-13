<?php
include('session.php');
include('header.php');
include('conn.php');

$id = $_GET['id'];
$rawQuery = "
SELECT invoice.customer_name, 
       invoice.date, 
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
    die('Query failed: ' . mysqli_error($conn));   
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

<nav>
    <div class="nav-wrapper green">
        <a href="#" class="brand-logo">Invoice Details</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="welcomepage.php"><i class="material-icons left">home</i>Home</a></li>
            <li><a href="invoicelist.php"><i class="material-icons left">list</i>Invoice List</a></li>
            <li><a href="invoice.php"><i class="material-icons left">add</i>New Invoice</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12 m6">
                            <h5>Customer Information</h5>
                            <p><strong>Name:</strong> <?php echo $customerInfo['customer_name']; ?></p>
                            <p><strong>Invoice Date:</strong> <?php echo $customerInfo['date']; ?></p>
                            <p><strong>Invoice ID:</strong> <?php echo $id; ?></p>
                        </div>
                        <div class="col s12 m6 right-align">
                            <h5>Company Information</h5>
                            <p>Your Company Name</p>
                            <p>123 Business Street</p>
                            <p>City, Country</p>
                            <p>Phone: (123) 456-7890</p>
                        </div>
                    </div>
                    
                    <div class="divider" style="margin: 20px 0;"></div>
                    
                    <h5>Invoice Items</h5>
                    <table class="striped responsive-table">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>MRP</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($records)) { ?>
                            <tr>
                                <td><?php echo isset($row['id']) ? $row['id'] : 'N/A'; ?></td>
                                <td><?php echo isset($row['item_name']) ? $row['item_name'] : 'N/A'; ?></td>
                                <td><?php echo isset($row['qty']) ? $row['qty'] : 'N/A'; ?></td>
                                <td><?php echo isset($row['mrp']) ? '₹'.number_format($row['mrp'], 2) : 'N/A'; ?></td>
                                <td><?php echo isset($row['total_price']) ? '₹'.number_format($row['total_price'], 2) : 'N/A'; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="right-align">Total Amount:</th>
                                <th><?php echo '₹'.number_format($totalAmount, 2); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="card-action">
                    <div class="row">
                        <div class="col s12 m6">
                            <p>Thank you for your business!</p>
                        </div>
                        <div class="col s12 m6 right-align">
                            <a href="invoicelist.php" class="btn waves-effect waves-light blue">
                                <i class="material-icons left">arrow_back</i> Back to Invoices
                            </a>
                            <a href="#" onclick="window.print()" class="btn waves-effect waves-light green">
                                <i class="material-icons left">print</i> Print Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</html>
