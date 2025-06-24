<?php
include('session.php');
include('header.php');
include('navigation.php');
include('conn.php');
$rawQuery = "SELECT * FROM user";
$records = mysqli_query($conn, $rawQuery);
?>
    <li><a href="table.php"><i class="material-icons left">people</i>Users</a></li>
    <li><a href="logout.php"><i class="material-icons left">logout</i>Logout</a></li>
</ul>

<div class="container">
    <!-- Header Section -->
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text center-align">
                    <i class="material-icons large">add_box</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">Create New Invoice</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Generate professional invoices for your customers</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card hoverable z-depth-2">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left" style="color: var(--accent-light);">receipt</i>
                        Invoice Details
                    </span>
                    <div class="divider" style="margin: 20px 0;"></div>
                    
                    <form method="post" action="invoicebill.php" id="invoiceForm">
                        <!-- Customer Information Section -->
                        <div class="section-header">
                            <h6><i class="material-icons left">person</i>Customer Information</h6>
                            <p style="color: var(--text-secondary); font-size: 14px; margin-top: 5px;">
                                Select an existing customer or the system will create a new customer record.
                            </p>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person_outline</i>
                                <select id="selectname" name="customername" required>
                                    <option value="" disabled selected>Select a Customer</option>
                                    <?php
                                    mysqli_data_seek($records, 0);
                                    while ($row = mysqli_fetch_array($records)) {
                                    ?>
                                    <option value="<?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>"
                                            data-email="<?php echo htmlspecialchars($row['email']); ?>">
                                        <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <label>Customer Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">email</i>
                                <input type="email" name="emailid" id="email" readonly>
                                <label for="email">Customer Email</label>
                            </div>
                        </div>

                        <!-- Invoice Items Section -->
                        <div class="section-header" style="margin-top: 30px;">
                            <h6><i class="material-icons left">shopping_cart</i>Invoice Items</h6>
                            <p style="color: var(--text-secondary); font-size: 14px; margin-top: 5px;">
                                Add items to your invoice. Click the "+" button to add more items.
                            </p>
                        </div>

                        <div class="card-panel" style="background: var(--glass-bg); border: 1px solid var(--glass-border);">
                            <div class="items-container" id="demo">
                                <div class="row item-row" style="background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 15px; align-items: flex-end;">
                                    <div class="input-field col s12 m3">
                                        <i class="material-icons prefix">inventory</i>
                                        <input type="text" name="itemname[]" required>
                                        <label>Item Name</label>
                                    </div>
                                    <div class="input-field col s12 m2">
                                        <i class="material-icons prefix">format_list_numbered</i>
                                        <input type="number" name="qty[]" id="qty_0" class="my-class" required min="1">
                                        <label>Quantity</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="material-icons prefix">attach_money</i>
                                        <input type="number" name="mrp[]" id="mrp_0" class="my-allclass" required step="0.01" min="0">
                                        <label>Unit Price (₹)</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <i class="material-icons prefix">calculate</i>
                                        <input type="number" name="price[]" id="price_0" class="my-allclass2" readonly>
                                        <label>Total Price (₹)</label>
                                    </div>
                                    <div class="col s12 m1 center-align" style="padding-bottom: 1rem;">
                                        <button type="button" id="btn1" class="btn-floating waves-effect waves-light tooltipped pulse"
                                                data-tooltip="Add Another Item" data-position="top">
                                            <i class="material-icons">add</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Invoice Summary Section -->
                        <div class="section-header" style="margin-top: 30px;">
                            <h6><i class="material-icons left">calculate</i>Invoice Summary</h6>
                            <p style="color: var(--text-secondary); font-size: 14px; margin-top: 5px;">
                                Review the total quantities and amounts before generating the invoice.
                            </p>
                        </div>

                        <div class="card-panel" style="background: linear-gradient(135deg, rgba(108, 92, 231, 0.1), rgba(162, 155, 254, 0.1)); border: 1px solid var(--glass-border);">
                            <div class="row" style="align-items: flex-end; margin-bottom: 0;">
                                <div class="input-field col s12 m4">
                                    <i class="material-icons prefix">shopping_cart</i>
                                    <input type="number" name="totalqty" id="tx" readonly required>
                                    <label for="tx">Total Quantity</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <i class="material-icons prefix">account_balance_wallet</i>
                                    <input type="number" name="totalamount" id="tz" readonly required step="0.01">
                                    <label for="tz">Total Amount (₹)</label>
                                </div>
                                <div class="col s12 m4 center-align" style="padding-bottom: 1rem;">
                                    <button type="button" id="btn2" class="btn waves-effect waves-light tooltipped"
                                            data-tooltip="Calculate Total Quantities and Amounts" data-position="top">
                                        <i class="material-icons left">calculate</i>Calculate Totals
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col s12 center-align" style="margin-top: 30px;">
                                <div class="btn-group">
                                    <button type="button" class="btn-large waves-effect waves-light btn-secondary">
                                        <i class="material-icons left">save</i>Save Draft
                                    </button>
                                    <button type="submit" name="submit" class="btn-large waves-effect waves-light">
                                        <i class="material-icons left">receipt</i>Generate Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.section-header {
    margin: 25px 0 15px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--glass-border);
}

.section-header h6 {
    color: var(--accent-light);
    font-weight: 500;
    margin: 0;
}

.items-container .item-row {
    transition: all 0.3s ease;
    position: relative;
}

.items-container .item-row:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(108, 92, 231, 0.2);
}

.item-row.removing {
    animation: slideOut 0.3s ease-out forwards;
}

@keyframes slideOut {
    to {
        transform: translateX(-100%);
        opacity: 0;
        height: 0;
        margin: 0;
        padding: 0;
    }
}

.btn-floating.pulse {
    animation: pulse 2s infinite;
}

.total-display {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 10px;
    padding: 15px;
    margin-top: 15px;
}

.total-display h6 {
    color: var(--accent-light);
    margin: 0 0 10px 0;
}

.total-amount {
    font-size: 24px;
    font-weight: 600;
    color: var(--accent-light);
    font-family: 'Roboto Mono', monospace;
}

.form-validation-error {
    border-bottom: 2px solid #f44336 !important;
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    75% { transform: translateX(5px); }
}

.success-animation {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: var(--accent-light);
    color: white;
    padding: 20px;
    border-radius: 10px;
    z-index: 1000;
    opacity: 0;
    animation: successPop 0.6s ease-out forwards;
}

@keyframes successPop {
    0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
    50% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Materialize components
    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems);

    var sidenavElems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavElems);

    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips);
    
    // Handle customer selection
    document.getElementById('selectname').addEventListener('change', function() {
        var select = this;
        var option = select.options[select.selectedIndex];
        var email = option.getAttribute('data-email');
        document.getElementById('email').value = email;
        document.getElementById('email').nextElementSibling.classList.add('active');
    });
    
    // Calculate price for first row
    function updateFirstRowPrice() {
        var qty = parseFloat(document.getElementById('qty_0').value) || 0;
        var mrp = parseFloat(document.getElementById('mrp_0').value) || 0;
        var price = qty * mrp;
        document.getElementById('price_0').value = price.toFixed(2);
    }
    
    document.getElementById('qty_0').addEventListener('input', function() {
        updateFirstRowPrice();
        updateLiveTotals();
    });
    document.getElementById('mrp_0').addEventListener('input', function() {
        updateFirstRowPrice();
        updateLiveTotals();
    });
    
    // Row counter for new rows
    var rowCounter = 1;
    
    // Add more items with enhanced styling
    document.getElementById('btn1').addEventListener('click', function() {
        var newRow = document.createElement('div');
        newRow.className = 'row item-row';
        newRow.style.cssText = 'background: rgba(255,255,255,0.05); padding: 20px; border-radius: 10px; margin-bottom: 15px; opacity: 0; transform: translateY(20px); align-items: flex-end;';

        var rowId = rowCounter;
        newRow.innerHTML =
            '<div class="input-field col s12 m3"><i class="material-icons prefix">inventory</i><input type="text" name="itemname[]" required><label class="active">Item Name</label></div>' +
            '<div class="input-field col s12 m2"><i class="material-icons prefix">format_list_numbered</i><input type="number" name="qty[]" id="qty_' + rowId + '" class="my-class" required min="1"><label class="active">Quantity</label></div>' +
            '<div class="input-field col s12 m3"><i class="material-icons prefix">attach_money</i><input type="number" name="mrp[]" id="mrp_' + rowId + '" class="my-allclass" required step="0.01" min="0"><label class="active">Unit Price (₹)</label></div>' +
            '<div class="input-field col s12 m3"><i class="material-icons prefix">calculate</i><input type="number" name="price[]" id="price_' + rowId + '" class="my-allclass2" readonly><label class="active">Total Price (₹)</label></div>' +
            '<div class="col s12 m1 center-align" style="padding-bottom: 1rem;"><button type="button" class="remove-btn btn-floating waves-effect waves-light red tooltipped" data-tooltip="Remove Item" data-position="top"><i class="material-icons">remove</i></button></div>';

        document.getElementById('demo').appendChild(newRow);

        // Animate the new row
        setTimeout(() => {
            newRow.style.transition = 'all 0.5s ease';
            newRow.style.opacity = '1';
            newRow.style.transform = 'translateY(0)';
        }, 50);

        // Initialize tooltips for new row
        var newTooltips = newRow.querySelectorAll('.tooltipped');
        M.Tooltip.init(newTooltips);

        // Add event listeners for new row
        document.getElementById('qty_' + rowId).addEventListener('input', function() {
            updateRowPrice(rowId);
            updateLiveTotals();
        });

        document.getElementById('mrp_' + rowId).addEventListener('input', function() {
            updateRowPrice(rowId);
            updateLiveTotals();
        });

        rowCounter++;

        // Show success message
        M.toast({html: 'New item row added!', classes: 'green'});
    });
    
    // Function to update price for a specific row
    function updateRowPrice(rowId) {
        var qty = parseFloat(document.getElementById('qty_' + rowId).value) || 0;
        var mrp = parseFloat(document.getElementById('mrp_' + rowId).value) || 0;
        var price = qty * mrp;
        document.getElementById('price_' + rowId).value = price.toFixed(2);
    }
    
    // Enhanced event delegation for remove buttons
    document.getElementById('demo').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-btn') || e.target.parentElement.classList.contains('remove-btn')) {
            var button = e.target.classList.contains('remove-btn') ? e.target : e.target.parentElement;
            var row = button.closest('.item-row');

            // Check if this is the last row
            var allRows = document.querySelectorAll('.item-row');
            if (allRows.length <= 1) {
                M.toast({html: 'Cannot remove the last item row!', classes: 'red'});
                return;
            }

            // Animate removal
            row.classList.add('removing');
            setTimeout(() => {
                row.parentNode.removeChild(row);
                updateLiveTotals();
                M.toast({html: 'Item removed successfully!', classes: 'orange'});
            }, 300);
        }
    });

    // Live totals update
    function updateLiveTotals() {
        var qtyInputs = document.querySelectorAll('input[name="qty[]"]');
        var priceInputs = document.querySelectorAll('input[name="price[]"]');
        var totalQty = 0;
        var totalAmount = 0;

        for (var i = 0; i < qtyInputs.length; i++) {
            totalQty += parseFloat(qtyInputs[i].value) || 0;
        }

        for (var i = 0; i < priceInputs.length; i++) {
            totalAmount += parseFloat(priceInputs[i].value) || 0;
        }

        // Update live display if exists
        var liveDisplay = document.getElementById('live-totals');
        if (!liveDisplay) {
            liveDisplay = document.createElement('div');
            liveDisplay.id = 'live-totals';
            liveDisplay.className = 'total-display';
            liveDisplay.innerHTML = '<h6><i class="material-icons left tiny">info</i>Live Totals</h6><div class="live-qty">Quantity: <span>0</span></div><div class="live-amount">Amount: <span class="total-amount">₹0.00</span></div>';
            document.querySelector('.items-container').appendChild(liveDisplay);
        }

        liveDisplay.querySelector('.live-qty span').textContent = totalQty;
        liveDisplay.querySelector('.live-amount .total-amount').textContent = '₹' + totalAmount.toFixed(2);
    }
    
    // Calculate totals
    document.getElementById('btn2').addEventListener('click', function() {
        var qtyInputs = document.querySelectorAll('input[name="qty[]"]');
        var totalQty = 0;
        
        for (var i = 0; i < qtyInputs.length; i++) {
            totalQty += parseFloat(qtyInputs[i].value) || 0;
        }
        
        document.getElementById('tx').value = totalQty;
        document.getElementById('tx').nextElementSibling.classList.add('active');
        
        var priceInputs = document.querySelectorAll('input[name="price[]"]');
        var totalAmount = 0;
        
        for (var i = 0; i < priceInputs.length; i++) {
            totalAmount += parseFloat(priceInputs[i].value) || 0;
        }
        
        document.getElementById('tz').value = totalAmount.toFixed(2);
        document.getElementById('tz').nextElementSibling.classList.add('active');
    });
});
</script>

<?php include('footer.php'); ?>
