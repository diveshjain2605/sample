<?php
/**
 * Add 50 New Users to Warehouse Pro Database
 * This script generates realistic user data and inserts them into the database
 */

include('conn.php');

echo "<!DOCTYPE html>
<html>
<head>
    <title>Add 50 New Users - Warehouse Pro</title>
    <style>
        body { 
            font-family: 'Roboto', Arial, sans-serif; 
            max-width: 1000px; 
            margin: 0 auto; 
            padding: 20px; 
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #ffffff;
            min-height: 100vh;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        .success { 
            color: #4CAF50; 
            background: rgba(76, 175, 80, 0.1); 
            padding: 15px; 
            border-radius: 10px; 
            margin: 10px 0; 
            border-left: 4px solid #4CAF50;
        }
        .error { 
            color: #f44336; 
            background: rgba(244, 67, 54, 0.1); 
            padding: 15px; 
            border-radius: 10px; 
            margin: 10px 0; 
            border-left: 4px solid #f44336;
        }
        .info { 
            color: #2196F3; 
            background: rgba(33, 150, 243, 0.1); 
            padding: 15px; 
            border-radius: 10px; 
            margin: 10px 0; 
            border-left: 4px solid #2196F3;
        }
        .warning { 
            color: #ff9800; 
            background: rgba(255, 152, 0, 0.1); 
            padding: 15px; 
            border-radius: 10px; 
            margin: 10px 0; 
            border-left: 4px solid #ff9800;
        }
        .btn { 
            background: linear-gradient(135deg, #6c5ce7, #a29bfe); 
            color: white; 
            padding: 12px 24px; 
            text-decoration: none; 
            border-radius: 25px; 
            display: inline-block; 
            margin: 10px 5px; 
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4);
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin: 20px 0; 
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td { 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background: rgba(108, 92, 231, 0.3); 
            color: white; 
            font-weight: 600;
        }
        tr:nth-child(even) {
            background: rgba(255, 255, 255, 0.02);
        }
        tr:hover {
            background: rgba(108, 92, 231, 0.1);
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #6c5ce7, #a29bfe);
            width: 0%;
            transition: width 0.3s ease;
        }
        h1, h2, h3 {
            color: #a29bfe;
            text-align: center;
        }
    </style>
</head>
<body>";

echo "<div class='container'>";
echo "<h1>🚀 Adding 50 New Users to Warehouse Pro</h1>";

// Sample user data arrays
$firstNames = [
    'James', 'Mary', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda', 'William', 'Elizabeth',
    'David', 'Barbara', 'Richard', 'Susan', 'Joseph', 'Jessica', 'Thomas', 'Sarah', 'Christopher', 'Karen',
    'Charles', 'Nancy', 'Daniel', 'Lisa', 'Matthew', 'Betty', 'Anthony', 'Helen', 'Mark', 'Sandra',
    'Donald', 'Donna', 'Steven', 'Carol', 'Paul', 'Ruth', 'Andrew', 'Sharon', 'Joshua', 'Michelle',
    'Kenneth', 'Laura', 'Kevin', 'Sarah', 'Brian', 'Kimberly', 'George', 'Deborah', 'Edward', 'Dorothy'
];

$lastNames = [
    'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
    'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin',
    'Lee', 'Perez', 'Thompson', 'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson',
    'Walker', 'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores',
    'Green', 'Adams', 'Nelson', 'Baker', 'Hall', 'Rivera', 'Campbell', 'Mitchell', 'Carter', 'Roberts'
];

$domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'company.com', 'business.org', 'email.com'];

try {
    echo "<div class='info'><strong>Step 1:</strong> Preparing to add 50 new users...</div>";
    
    // Check if user table exists
    $checkTable = mysqli_query($conn, "SHOW TABLES LIKE 'user'");
    if (mysqli_num_rows($checkTable) == 0) {
        throw new Exception("User table does not exist. Please run database setup first.");
    }
    
    echo "<div class='success'>✓ User table found</div>";
    
    // Get current user count
    $countQuery = mysqli_query($conn, "SELECT COUNT(*) as count FROM user");
    $currentCount = mysqli_fetch_assoc($countQuery)['count'];
    echo "<div class='info'>Current users in database: $currentCount</div>";
    
    echo "<div class='progress-bar'><div class='progress-fill' id='progress'></div></div>";
    echo "<div id='progress-text'>Starting user creation...</div>";
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    $successCount = 0;
    $errors = [];
    
    // Prepare statement for better performance
    $stmt = mysqli_prepare($conn, "INSERT INTO user (first_name, last_name, email, user_name, password) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . mysqli_error($conn));
    }
    
    echo "<h3>Creating Users:</h3>";
    echo "<table>";
    echo "<tr><th>#</th><th>Name</th><th>Username</th><th>Email</th><th>Status</th></tr>";
    
    for ($i = 1; $i <= 50; $i++) {
        // Generate random user data
        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];
        $domain = $domains[array_rand($domains)];
        
        // Create unique username and email
        $baseUsername = strtolower($firstName . $lastName);
        $username = $baseUsername . rand(100, 999);
        $email = strtolower($firstName . '.' . $lastName . rand(10, 99) . '@' . $domain);
        
        // Generate password (in real scenario, this should be hashed properly)
        $password = md5('password123'); // Default password for all users
        
        // Check if username or email already exists
        $checkQuery = mysqli_query($conn, "SELECT id FROM user WHERE user_name = '$username' OR email = '$email'");
        if (mysqli_num_rows($checkQuery) > 0) {
            // If exists, modify username and email
            $username = $baseUsername . rand(1000, 9999);
            $email = strtolower($firstName . '.' . $lastName . rand(100, 999) . '@' . $domain);
        }
        
        // Bind parameters and execute
        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $username, $password);
        
        if (mysqli_stmt_execute($stmt)) {
            $successCount++;
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$firstName $lastName</td>";
            echo "<td>$username</td>";
            echo "<td>$email</td>";
            echo "<td><span style='color: #4CAF50;'>✓ Success</span></td>";
            echo "</tr>";
        } else {
            $error = mysqli_stmt_error($stmt);
            $errors[] = "User $i ($firstName $lastName): $error";
            echo "<tr>";
            echo "<td>$i</td>";
            echo "<td>$firstName $lastName</td>";
            echo "<td>$username</td>";
            echo "<td>$email</td>";
            echo "<td><span style='color: #f44336;'>✗ Failed</span></td>";
            echo "</tr>";
        }
        
        // Update progress
        $progress = ($i / 50) * 100;
        echo "<script>
                document.getElementById('progress').style.width = '$progress%';
                document.getElementById('progress-text').innerHTML = 'Created $i of 50 users ($progress%)';
              </script>";
        
        // Small delay to show progress
        usleep(50000); // 0.05 seconds
    }
    
    echo "</table>";
    
    mysqli_stmt_close($stmt);
    
    // Commit transaction
    mysqli_commit($conn);
    
    echo "<div class='success'>";
    echo "<h2>🎉 User Creation Completed!</h2>";
    echo "<p><strong>Successfully created:</strong> $successCount users</p>";
    echo "<p><strong>Errors:</strong> " . count($errors) . "</p>";
    echo "</div>";
    
    if (!empty($errors)) {
        echo "<div class='warning'>";
        echo "<h3>Errors encountered:</h3>";
        foreach ($errors as $error) {
            echo "<p>• $error</p>";
        }
        echo "</div>";
    }
    
    // Show final statistics
    $newCountQuery = mysqli_query($conn, "SELECT COUNT(*) as count FROM user");
    $newCount = mysqli_fetch_assoc($newCountQuery)['count'];
    
    echo "<div class='info'>";
    echo "<h3>Database Statistics:</h3>";
    echo "<p><strong>Users before:</strong> $currentCount</p>";
    echo "<p><strong>Users after:</strong> $newCount</p>";
    echo "<p><strong>Users added:</strong> " . ($newCount - $currentCount) . "</p>";
    echo "</div>";
    
    // Show sample of created users
    echo "<h3>Sample of Created Users:</h3>";
    $sampleQuery = mysqli_query($conn, "SELECT first_name, last_name, user_name, email, created_at FROM user ORDER BY id DESC LIMIT 10");
    
    if ($sampleQuery && mysqli_num_rows($sampleQuery) > 0) {
        echo "<table>";
        echo "<tr><th>Name</th><th>Username</th><th>Email</th><th>Created</th></tr>";
        
        while ($row = mysqli_fetch_assoc($sampleQuery)) {
            echo "<tr>";
            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
            echo "<td>" . $row['user_name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . ($row['created_at'] ?? 'N/A') . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    }
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='table.php' class='btn'>View All Users</a>";
    echo "<a href='welcomepage.php' class='btn'>Go to Dashboard</a>";
    echo "<a href='index.php' class='btn'>Login Page</a>";
    echo "</div>";
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<div class='error'>";
    echo "<h3>❌ Error during user creation:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "</div>";
    
    echo "<div style='text-align: center; margin: 30px 0;'>";
    echo "<a href='database_schema_fix.php' class='btn'>Fix Database</a>";
    echo "<a href='welcomepage.php' class='btn'>Go to Dashboard</a>";
    echo "</div>";
}

mysqli_close($conn);

echo "</div>";
echo "</body></html>";
?>
