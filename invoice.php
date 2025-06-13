<?php
include('session.php');
include('header.php');
include('conn.php');
$rawQuery = "SELECT * FROM user";
$records = mysqli_query($conn, $rawQuery);
?>

<nav>
    <div class="nav-wrapper indigo darken-1">
        <div class="container">
            <a href="#" class="brand-logo">Create Invoice</a>
            <a href="#" data-target="mobile-nav" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="welcomepage.php"><i class="material-icons left">home</i>Home</a></li>
                <li><a href="invoicelist.php"><i class="material-icons left">list</i>Invoice List</a></li>
                <li><a href="logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<ul class="sidenav" id="mobile-nav">
    <li><a href="welcomepage.php"><i class="material-icons left">home</i>Home</a></li>
    <li><a href="invoicelist.php"><i class="material-icons left">list</i>Invoice List</a></li>
    <li><a href="logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
</ul>

<div class="container">
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card z-depth-2">
                <div class="card-content">
                    <span class="card-title indigo-text text-darken-1"><i class="material-icons left">receipt</i>New Invoice</span>
                    <div class="divider" style="margin: 20px 0;"></div>
                    
                    <form method="post" action="invoicebill.php">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <select id="selectname" name="customername" required>
                                    <option value="" disabled selected>Select a Customer</option>
                                    <?php 
                                    mysqli_data_seek($records, 0);
                                    while ($row = mysqli_fetch_array($records)) { 
                                    ?>
                                    <option value="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>" data-email="<?php echo $row['email']; ?>">
                                        <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                                <label>Customer Name</label>
                            </div>
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">email</i>
                                <input type="text" name="emailid" id="email" readonly>
                                <label for="email">Email ID</label>
                            </div>
                        </div>

                        <div class="card-panel grey lighten-4 z-depth-1">
                            <h5 class="indigo-text text-darken-1"><i class="material-icons left">shopping_cart</i>Invoice Items</h5>
                            <div class="divider" style="margin: 10px 0 20px 0;"></div>
                            
                            <div class="row" id="demo">
                                <div class="row item-row">
                                    <div class="input-field col s12 m3">
                                        <input type="text" name="itemname[]" required>
                                        <label>Item Name</label>
                                    </div>
                                    <div class="input-field col s12 m2">
                                        <input type="number" name="qty[]" id="qty_0" class="my-class" required>
                                        <label>Quantity</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <input type="number" name="mrp[]" id="mrp_0" class="my-allclass" required step="0.01">
                                        <label>MRP (₹)</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <input type="number" name="price[]" id="price_0" class="my-allclass2" readonly>
                                        <label>Total Price (₹)</label>
                                    </div>
                                    <div class="col s12 m1 center-align">
                                        <button type="button" id="btn1" class="btn-floating waves-effect waves-light indigo darken-1 pulse">
                                            <i class="material-icons">add</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-panel indigo lighten-5 z-depth-1" style="margin-top: 20px;">
                            <h5 class="indigo-text text-darken-1"><i class="material-icons left">calculate</i>Invoice Summary</h5>
                            <div class="divider" style="margin: 10px 0 20px 0;"></div>
                            
                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <i class="material-icons prefix">shopping_cart</i>
                                    <input type="number" name="totalqty" id="tx" readonly required>
                                    <label for="tx">Total Quantity</label>
                                </div>
                                <div class="input-field col s12 m4">
                                    <i class="material-icons prefix">attach_money</i>
                                    <input type="number" name="totalamount" id="tz" readonly required>
                                    <label for="tz">Total Amount (₹)</label>
                                </div>
                                <div class="col s12 m4 center-align" style="margin-top: 20px;">
                                    <button type="button" id="btn2" class="btn waves-effect waves-light blue darken-1">
                                        Calculate Totals <i class="material-icons right">calculate</i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 center-align" style="margin-top: 30px;">
                                <button type="submit" name="submit" class="btn-large waves-effect waves-light indigo darken-1">
                                    Generate Invoice <i class="material-icons right">receipt</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Materialize components
    var elems = document.querySelectorAll('select');
    M.FormSelect.init(elems);
    
    var sidenavElems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavElems);
    
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
    
    document.getElementById('qty_0').addEventListener('input', updateFirstRowPrice);
    document.getElementById('mrp_0').addEventListener('input', updateFirstRowPrice);
    
    // Row counter for new rows
    var rowCounter = 1;
    
    // Add more items
    document.getElementById('btn1').addEventListener('click', function() {
        var newRow = document.createElement('div');
        newRow.className = 'row item-row';
        
        var rowId = rowCounter;
        newRow.innerHTML = 
            '<div class="input-field col s12 m3"><input type="text" name="itemname[]" required><label class="active">Item Name</label></div>' +
            '<div class="input-field col s12 m2"><input type="number" name="qty[]" id="qty_' + rowId + '" class="my-class" required><label class="active">Quantity</label></div>' +
            '<div class="input-field col s12 m3"><input type="number" name="mrp[]" id="mrp_' + rowId + '" class="my-allclass" required><label class="active">MRP</label></div>' +
            '<div class="input-field col s12 m3"><input type="number" name="price[]" id="price_' + rowId + '" class="my-allclass2" readonly><label class="active">Total Price</label></div>' +
            '<div class="col s12 m1 center-align"><button type="button" class="remove-btn btn-floating waves-effect waves-light red"><i class="material-icons">remove</i></button></div>';
        
        document.getElementById('demo').appendChild(newRow);
        
        // Add event listeners for new row
        document.getElementById('qty_' + rowId).addEventListener('input', function() {
            updateRowPrice(rowId);
        });
        
        document.getElementById('mrp_' + rowId).addEventListener('input', function() {
            updateRowPrice(rowId);
        });
        
        rowCounter++;
    });
    
    // Function to update price for a specific row
    function updateRowPrice(rowId) {
        var qty = parseFloat(document.getElementById('qty_' + rowId).value) || 0;
        var mrp = parseFloat(document.getElementById('mrp_' + rowId).value) || 0;
        var price = qty * mrp;
        document.getElementById('price_' + rowId).value = price.toFixed(2);
    }
    
    // Event delegation for remove buttons
    document.getElementById('demo').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-btn') || e.target.parentElement.classList.contains('remove-btn')) {
            var button = e.target.classList.contains('remove-btn') ? e.target : e.target.parentElement;
            var row = button.closest('.item-row');
            row.parentNode.removeChild(row);
        }
    });
    
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
