<?php
include('session.php');
include('header.php');
include('conn.php');
$rawQuery = "SELECT * FROM user";
$records = mysqli_query($conn, $rawQuery);
?>

<nav>
    <div class="nav-wrapper green">
        <a href="#" class="brand-logo">Create Invoice</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="welcomepage.php"><i class="material-icons left">home</i>Home</a></li>
            <li><a href="invoicelist.php"><i class="material-icons left">list</i>Invoice List</a></li>
            <li><a href="logout.php"><i class="material-icons left">exit_to_app</i>Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col s12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">New Invoice</span>
                    <form method="post" action="invoicebill.php">
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <i class="material-icons prefix">person</i>
                                <select id="selectname" name="customername" required>
                                    <option value="" disabled selected>Select a Customer</option>
                                    <?php while ($row = mysqli_fetch_array($records)) { ?>
                                    <option value="<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>">
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

                        <div class="card-panel grey lighten-4">
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
                                        <input type="number" name="mrp[]" id="mrp_0" class="my-allclass" required>
                                        <label>MRP</label>
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <input type="number" name="price[]" id="price_0" class="my-allclass2" readonly>
                                        <label>Total Price</label>
                                    </div>
                                    <div class="col s12 m1 center-align">
                                        <button type="button" id="btn1" class="btn-floating waves-effect waves-light green">
                                            <i class="material-icons">add</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">shopping_cart</i>
                                <input type="number" name="totalqty" id="tx" readonly required>
                                <label for="tx">Total Quantity</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <i class="material-icons prefix">attach_money</i>
                                <input type="number" name="totalamount" id="tz" readonly required>
                                <label for="tz">Total Amount</label>
                            </div>
                            <div class="col s12 m4 center-align" style="margin-top: 20px;">
                                <button type="button" id="btn2" class="btn waves-effect waves-light blue">
                                    Calculate Totals <i class="material-icons right">calculate</i>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 center-align" style="margin-top: 20px;">
                                <button type="submit" name="submit" class="btn waves-effect waves-light green">
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
$(document).ready(function() {
    $("#btn1").click(function() {
        var addmore =
            '<div class="row item-row">' +
            '<div class="input-field col s12 m3"><input type="text" name="itemname[]" required><label>Item Name</label></div>' +
            '<div class="input-field col s12 m2"><input type="number" name="qty[]" class="my-class" required><label>Quantity</label></div>' +
            '<div class="input-field col s12 m3"><input type="number" name="mrp[]" class="my-allclass" required><label>MRP</label></div>' +
            '<div class="input-field col s12 m3"><input type="number" name="price[]" class="my-allclass2" readonly><label>Total Price</label></div>' +
            '<div class="col s12 m1 center-align"><button type="button" class="remove-btn btn-floating waves-effect waves-light red"><i class="material-icons">remove</i></button></div>' +
            "</div>";

        $("#demo").append(addmore);
    });
    $(document).on("click", ".remove-btn", function() {
        $(this).closest(".item-row").remove();
    });
    $(document).on("input", "input[name='qty[]'], input[name='mrp[]']", function() {
        var $row = $(this).closest('.row');
        var qty = parseFloat($row.find('input[name="qty[]"]').val());
        var mrp = parseFloat($row.find('input[name="mrp[]"]').val());
        var totalPrice = qty * mrp;
        $row.find('input[name="price[]"]').val(totalPrice);
    });
    $("#btn2").click(function() {
        let totalQty = 0;
        $('.my-class').each(function() {
            const qtyValue = parseFloat($(this).val());
            if (!isNaN(qtyValue)) {
                totalQty += qtyValue;
            }
        });
        $('#tx').val(totalQty);
        let totalAmount = 0;
        $('.my-allclass2').each(function() {
            const priceValue = parseFloat($(this).val());
            if (!isNaN(priceValue)) {
                totalAmount += priceValue;
            }
        });
        $('#tz').val(totalAmount);
    });
});
</script>

</body>
