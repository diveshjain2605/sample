<?php
/**
 * Quick Add 50 Users - One Click Solution
 * Simple script to instantly add 50 users to the database
 */

include('conn.php');

// Sample data
$users = [
    ['James', 'Smith', 'james.smith@gmail.com', 'jamessmith101'],
    ['Mary', 'Johnson', 'mary.johnson@yahoo.com', 'maryjohnson102'],
    ['John', 'Williams', 'john.williams@hotmail.com', 'johnwilliams103'],
    ['Patricia', 'Brown', 'patricia.brown@outlook.com', 'patriciabrown104'],
    ['Robert', 'Jones', 'robert.jones@gmail.com', 'robertjones105'],
    ['Jennifer', 'Garcia', 'jennifer.garcia@company.com', 'jennifergarcia106'],
    ['Michael', 'Miller', 'michael.miller@business.org', 'michaelmiller107'],
    ['Linda', 'Davis', 'linda.davis@email.com', 'lindadavis108'],
    ['William', 'Rodriguez', 'william.rodriguez@gmail.com', 'williamrodriguez109'],
    ['Elizabeth', 'Martinez', 'elizabeth.martinez@yahoo.com', 'elizabethmartinez110'],
    ['David', 'Hernandez', 'david.hernandez@hotmail.com', 'davidhernandez111'],
    ['Barbara', 'Lopez', 'barbara.lopez@outlook.com', 'barbaralopez112'],
    ['Richard', 'Gonzalez', 'richard.gonzalez@gmail.com', 'richardgonzalez113'],
    ['Susan', 'Wilson', 'susan.wilson@company.com', 'susanwilson114'],
    ['Joseph', 'Anderson', 'joseph.anderson@business.org', 'josephanderson115'],
    ['Jessica', 'Thomas', 'jessica.thomas@email.com', 'jessicathomas116'],
    ['Thomas', 'Taylor', 'thomas.taylor@gmail.com', 'thomastaylor117'],
    ['Sarah', 'Moore', 'sarah.moore@yahoo.com', 'sarahmoore118'],
    ['Christopher', 'Jackson', 'christopher.jackson@hotmail.com', 'christopherjackson119'],
    ['Karen', 'Martin', 'karen.martin@outlook.com', 'karenmartin120'],
    ['Charles', 'Lee', 'charles.lee@gmail.com', 'charleslee121'],
    ['Nancy', 'Perez', 'nancy.perez@company.com', 'nancyperez122'],
    ['Daniel', 'Thompson', 'daniel.thompson@business.org', 'danielthompson123'],
    ['Lisa', 'White', 'lisa.white@email.com', 'lisawhite124'],
    ['Matthew', 'Harris', 'matthew.harris@gmail.com', 'matthewharris125'],
    ['Betty', 'Sanchez', 'betty.sanchez@yahoo.com', 'bettysanchez126'],
    ['Anthony', 'Clark', 'anthony.clark@hotmail.com', 'anthonyclark127'],
    ['Helen', 'Ramirez', 'helen.ramirez@outlook.com', 'helenramirez128'],
    ['Mark', 'Lewis', 'mark.lewis@gmail.com', 'marklewis129'],
    ['Sandra', 'Robinson', 'sandra.robinson@company.com', 'sandrarobinson130'],
    ['Donald', 'Walker', 'donald.walker@business.org', 'donaldwalker131'],
    ['Donna', 'Young', 'donna.young@email.com', 'donnayoung132'],
    ['Steven', 'Allen', 'steven.allen@gmail.com', 'stevenallen133'],
    ['Carol', 'King', 'carol.king@yahoo.com', 'carolking134'],
    ['Paul', 'Wright', 'paul.wright@hotmail.com', 'paulwright135'],
    ['Ruth', 'Scott', 'ruth.scott@outlook.com', 'ruthscott136'],
    ['Andrew', 'Torres', 'andrew.torres@gmail.com', 'andrewtorres137'],
    ['Sharon', 'Nguyen', 'sharon.nguyen@company.com', 'sharonnguyen138'],
    ['Joshua', 'Hill', 'joshua.hill@business.org', 'joshuahill139'],
    ['Michelle', 'Flores', 'michelle.flores@email.com', 'michelleflores140'],
    ['Kenneth', 'Green', 'kenneth.green@gmail.com', 'kennethgreen141'],
    ['Laura', 'Adams', 'laura.adams@yahoo.com', 'lauraadams142'],
    ['Kevin', 'Nelson', 'kevin.nelson@hotmail.com', 'kevinnelson143'],
    ['Kimberly', 'Baker', 'kimberly.baker@outlook.com', 'kimberlybaker144'],
    ['George', 'Hall', 'george.hall@gmail.com', 'georgehall145'],
    ['Deborah', 'Rivera', 'deborah.rivera@company.com', 'deborahrivera146'],
    ['Edward', 'Campbell', 'edward.campbell@business.org', 'edwardcampbell147'],
    ['Dorothy', 'Mitchell', 'dorothy.mitchell@email.com', 'dorothymitchell148'],
    ['Ronald', 'Carter', 'ronald.carter@gmail.com', 'ronaldcarter149'],
    ['Amy', 'Roberts', 'amy.roberts@yahoo.com', 'amyroberts150']
];

echo "<!DOCTYPE html>
<html>
<head>
    <title>Quick Add 50 Users - Warehouse Pro</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <style>
        body { 
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #ffffff;
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
        }
        .container { margin-top: 30px; }
        .card {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }
        .success { 
            color: #4CAF50; 
            background: rgba(76, 175, 80, 0.1); 
            padding: 20px; 
            border-radius: 15px; 
            margin: 20px 0; 
            text-align: center;
            border: 2px solid #4CAF50;
        }
        .error { 
            color: #f44336; 
            background: rgba(244, 67, 54, 0.1); 
            padding: 20px; 
            border-radius: 15px; 
            margin: 20px 0; 
            text-align: center;
            border: 2px solid #f44336;
        }
        .btn { 
            background: linear-gradient(135deg, #6c5ce7, #a29bfe) !important; 
            border-radius: 25px !important; 
            margin: 10px 5px !important;
        }
        .btn:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4) !important;
        }
        .stats-card {
            background: rgba(108, 92, 231, 0.1);
            border: 1px solid rgba(108, 92, 231, 0.3);
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            text-align: center;
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #a29bfe;
        }
    </style>
</head>
<body>";

echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col s12'>";
echo "<div class='card'>";
echo "<div class='card-content'>";

echo "<div class='center-align'>";
echo "<h3><i class='material-icons large' style='color: #a29bfe;'>group_add</i></h3>";
echo "<h4>Quick Add 50 Users</h4>";
echo "<p>Adding 50 predefined users to your Warehouse Pro database...</p>";
echo "</div>";

try {
    // Start transaction
    mysqli_begin_transaction($conn);
    
    $successCount = 0;
    $duplicateCount = 0;
    $errorCount = 0;
    
    // Prepare statement
    $stmt = mysqli_prepare($conn, "INSERT INTO user (first_name, last_name, email, user_name, password) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
    }
    
    foreach ($users as $index => $userData) {
        $firstName = $userData[0];
        $lastName = $userData[1];
        $email = $userData[2];
        $username = $userData[3];
        $password = md5('password123'); // Default password
        
        // Check for duplicates
        $checkQuery = mysqli_query($conn, "SELECT id FROM user WHERE user_name = '$username' OR email = '$email'");
        if (mysqli_num_rows($checkQuery) > 0) {
            // Modify to make unique
            $username = $username . '_' . time() . rand(10, 99);
            $email = str_replace('@', '_' . rand(10, 99) . '@', $email);
            $duplicateCount++;
        }
        
        // Bind and execute
        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $username, $password);
        
        if (mysqli_stmt_execute($stmt)) {
            $successCount++;
        } else {
            $errorCount++;
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_commit($conn);
    
    // Success message
    echo "<div class='success'>";
    echo "<h4><i class='material-icons large'>check_circle</i></h4>";
    echo "<h5>Users Added Successfully!</h5>";
    echo "<p>Operation completed successfully</p>";
    echo "</div>";
    
    // Statistics
    echo "<div class='row'>";
    echo "<div class='col s12 m4'>";
    echo "<div class='stats-card'>";
    echo "<div class='stats-number'>$successCount</div>";
    echo "<p>Users Added</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='col s12 m4'>";
    echo "<div class='stats-card'>";
    echo "<div class='stats-number'>$duplicateCount</div>";
    echo "<p>Duplicates Fixed</p>";
    echo "</div>";
    echo "</div>";
    
    echo "<div class='col s12 m4'>";
    echo "<div class='stats-card'>";
    echo "<div class='stats-number'>$errorCount</div>";
    echo "<p>Errors</p>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    
    // Get total user count
    $countQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM user");
    $totalUsers = mysqli_fetch_assoc($countQuery)['total'];
    
    echo "<div class='center-align' style='margin: 30px 0;'>";
    echo "<h6>Total Users in Database: <span style='color: #a29bfe;'>$totalUsers</span></h6>";
    echo "</div>";
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<div class='error'>";
    echo "<h4><i class='material-icons large'>error</i></h4>";
    echo "<h5>Error Adding Users</h5>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
}

// Action buttons
echo "<div class='center-align' style='margin: 30px 0;'>";
echo "<a href='table.php' class='btn-large waves-effect waves-light'>";
echo "<i class='material-icons left'>people</i>View All Users";
echo "</a>";
echo "<a href='bulk_user_generator.php' class='btn-large waves-effect waves-light grey'>";
echo "<i class='material-icons left'>add_circle</i>Add More Users";
echo "</a>";
echo "<a href='welcomepage.php' class='btn-large waves-effect waves-light blue'>";
echo "<i class='material-icons left'>home</i>Dashboard";
echo "</a>";
echo "</div>";

echo "</div></div></div></div></div>";

// Show sample of recent users
echo "<div class='row'>";
echo "<div class='col s12'>";
echo "<div class='card'>";
echo "<div class='card-content'>";
echo "<span class='card-title'>Recent Users Added</span>";

$recentQuery = mysqli_query($conn, "SELECT first_name, last_name, user_name, email FROM user ORDER BY id DESC LIMIT 10");

if ($recentQuery && mysqli_num_rows($recentQuery) > 0) {
    echo "<table class='striped responsive-table'>";
    echo "<thead>";
    echo "<tr><th>Name</th><th>Username</th><th>Email</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    
    while ($row = mysqli_fetch_assoc($recentQuery)) {
        echo "<tr>";
        echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
        echo "<td>" . $row['user_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "</tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
} else {
    echo "<p class='center-align'>No users found in database.</p>";
}

echo "</div></div></div></div>";

mysqli_close($conn);

echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>";
echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        M.AutoInit();
        
        // Auto-scroll to show results
        setTimeout(() => {
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            });
        }, 1000);
    });
</script>";

echo "</body></html>";
?>
