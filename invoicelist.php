<?php
include('session.php');
include('header.php');
include('conn.php');

$start = @$_GET['start'] ?? 0;
$end = @$_GET['end'] ?? 10;
$search = @$_GET['search'] ?? '';

$totalamountQuery = "
SELECT
invoice.*,
 SUM(invoice_item.total_price) AS total_amount
FROM invoice_item
LEFT JOIN invoice ON invoice_item.invoice_id = invoice.id
WHERE customer_name LIKE '%".$search."%'
GROUP BY 
invoice.id limit $start,$end
";
$records = mysqli_query($conn, $totalamountQuery);
if (!$records) {
    die('Query failed: ' . mysqli_error($conn));
}

// Count total records for pagination
$countQuery = "SELECT COUNT(DISTINCT invoice.id) as total FROM invoice 
               LEFT JOIN invoice_item ON invoice_item.invoice_id = invoice.id
               WHERE customer_name LIKE '%".$search."%'";
$countResult = mysqli_query($conn, $countQuery);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / 10);
?>

<nav>
    <div class="nav-wrapper green">
        <a href="#" class="brand-logo">Invoice List</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="welcomepage.php"><i class="material-icons left">home</i>Home</a></li>
            <li><a href="invoice.php"><i class="material-icons left">add</i>New Invoice</a></li>
            <li><a href="logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Invoice Records</span>
                    
                    <form action="invoicelist.php" method="GET" class="row">
                        <div class="input-field col s12 m6 offset-m3">
                            <i class="material-icons prefix">search</i>
                            <input type="text" name="search" id="search" value="<?php echo $search; ?>">
                            <label for="search">Search by Customer Name</label>
                            <button type="submit" class="btn waves-effect waves-light green right">
                                Search <i class="material-icons right">search</i>
                            </button>
                        </div>
                    </form>

                    <table class="striped responsive-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                                <th>Total Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if (mysqli_num_rows($records) > 0) {
                                while ($row = mysqli_fetch_assoc($records)) { 
                            ?>
                            <tr>
                                <td><?php echo isset($row['id']) ? $row['id'] : 'N/A'; ?></td>
                                <td><?php echo isset($row['customer_name']) ? $row['customer_name'] : 'N/A'; ?></td>
                                <td><?php echo isset($row['date']) ? $row['date'] : 'N/A'; ?></td>
                                <td><?php echo isset($row['total_amount']) ? '$'.number_format($row['total_amount'], 2) : 'N/A'; ?></td>
                                <td>
                                    <a href="itemlist.php?id=<?php echo $row['id']; ?>" class="btn-small waves-effect waves-light blue">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="5" class="center-align">No records found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-action">
                    <ul class="pagination center-align">
                        <li class="<?php echo ($start <= 0) ? 'disabled' : 'waves-effect'; ?>">
                            <a href="<?php echo ($start <= 0) ? '#' : 'invoicelist.php?start='.($start-10).'&end='.$end.'&search='.$search; ?>">
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
                                <a href="invoicelist.php?start=<?php echo $pageStart; ?>&end=<?php echo $pageEnd; ?>&search=<?php echo $search; ?>">
                                    <?php echo ($i + 1); ?>
                                </a>
                            </li>
                        <?php } ?>
                        
                        <li class="<?php echo ($start >= ($totalPages-1)*10) ? 'disabled' : 'waves-effect'; ?>">
                            <a href="<?php echo ($start >= ($totalPages-1)*10) ? '#' : 'invoicelist.php?start='.($start+10).'&end='.$end.'&search='.$search; ?>">
                                <i class="material-icons">chevron_right</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


