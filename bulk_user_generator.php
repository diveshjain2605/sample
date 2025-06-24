<?php
/**
 * Advanced Bulk User Generator for Warehouse Pro
 * Allows customization of user count and includes additional user details
 */

include('conn.php');

// Handle form submission
$userCount = isset($_POST['user_count']) ? (int)$_POST['user_count'] : 50;
$includeProfiles = isset($_POST['include_profiles']) ? true : false;
$generateAction = isset($_POST['generate']);

if (!$generateAction) {
    // Show form
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Bulk User Generator - Warehouse Pro</title>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css' rel='stylesheet'>
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
        <style>
            body { 
                background: linear-gradient(135deg, #1a1a2e, #16213e);
                color: #ffffff;
                min-height: 100vh;
                font-family: 'Roboto', sans-serif;
            }
            .container {
                margin-top: 50px;
            }
            .card {
                background: rgba(255, 255, 255, 0.1) !important;
                backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 20px;
            }
            .card-title {
                color: #a29bfe !important;
            }
            .input-field input, .input-field textarea {
                color: #ffffff !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.3) !important;
            }
            .input-field input:focus, .input-field textarea:focus {
                border-bottom: 2px solid #a29bfe !important;
                box-shadow: 0 1px 0 0 #a29bfe !important;
            }
            .input-field label {
                color: rgba(255, 255, 255, 0.7) !important;
            }
            .input-field label.active {
                color: #a29bfe !important;
            }
            .btn {
                background: linear-gradient(135deg, #6c5ce7, #a29bfe) !important;
                border-radius: 25px !important;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(108, 92, 231, 0.4) !important;
            }
            [type=\"checkbox\"]:checked + span:not(.lever):before {
                border-color: #a29bfe;
                background-color: #a29bfe;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='row'>
                <div class='col s12 m8 offset-m2'>
                    <div class='card'>
                        <div class='card-content'>
                            <span class='card-title center-align'>
                                <i class='material-icons left'>group_add</i>
                                Bulk User Generator
                            </span>
                            <p class='center-align'>Generate multiple users for testing and demonstration purposes</p>
                            
                            <form method='post' action=''>
                                <div class='row'>
                                    <div class='input-field col s12 m6'>
                                        <i class='material-icons prefix'>people</i>
                                        <input type='number' name='user_count' id='user_count' value='50' min='1' max='1000' required>
                                        <label for='user_count'>Number of Users to Generate</label>
                                    </div>
                                    <div class='col s12 m6' style='margin-top: 20px;'>
                                        <label>
                                            <input type='checkbox' name='include_profiles' checked />
                                            <span>Include Extended Profiles</span>
                                        </label>
                                        <p style='font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 5px;'>
                                            Adds phone numbers, addresses, and other details
                                        </p>
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col s12'>
                                        <div class='card-panel' style='background: rgba(33, 150, 243, 0.1); border: 1px solid rgba(33, 150, 243, 0.3);'>
                                            <h6><i class='material-icons left tiny'>info</i>Generation Details:</h6>
                                            <ul style='margin-left: 20px;'>
                                                <li>• Realistic names and email addresses</li>
                                                <li>• Unique usernames with random numbers</li>
                                                <li>• Default password: 'password123' (MD5 hashed)</li>
                                                <li>• Automatic duplicate prevention</li>
                                                <li>• Transaction-safe insertion</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class='row'>
                                    <div class='col s12 center-align'>
                                        <button type='submit' name='generate' class='btn-large waves-effect waves-light'>
                                            <i class='material-icons left'>play_arrow</i>
                                            Generate Users
                                        </button>
                                        <a href='welcomepage.php' class='btn-large waves-effect waves-light grey'>
                                            <i class='material-icons left'>arrow_back</i>
                                            Back to Dashboard
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                M.AutoInit();
            });
        </script>
    </body>
    </html>";
    exit();
}

// Generate users
echo "<!DOCTYPE html>
<html>
<head>
    <title>Generating Users - Warehouse Pro</title>
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
        .progress { background: rgba(255, 255, 255, 0.1) !important; }
        .progress .determinate { background: linear-gradient(135deg, #6c5ce7, #a29bfe) !important; }
        .btn { background: linear-gradient(135deg, #6c5ce7, #a29bfe) !important; border-radius: 25px !important; }
        .success { color: #4CAF50; background: rgba(76, 175, 80, 0.1); padding: 15px; border-radius: 10px; margin: 10px 0; }
        .error { color: #f44336; background: rgba(244, 67, 54, 0.1); padding: 15px; border-radius: 10px; margin: 10px 0; }
        .info { color: #2196F3; background: rgba(33, 150, 243, 0.1); padding: 15px; border-radius: 10px; margin: 10px 0; }
    </style>
</head>
<body>";

echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col s12'>";
echo "<div class='card'>";
echo "<div class='card-content'>";
echo "<span class='card-title center-align'>";
echo "<i class='material-icons left'>group_add</i>";
echo "Generating $userCount Users";
echo "</span>";

// Sample data arrays (same as before)
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

$domains = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'company.com', 'business.org'];

try {
    // Progress bar
    echo "<div class='progress'>";
    echo "<div class='determinate' id='progress-bar' style='width: 0%'></div>";
    echo "</div>";
    echo "<p id='progress-text' class='center-align'>Starting user generation...</p>";
    
    // Start transaction
    mysqli_begin_transaction($conn);
    
    $successCount = 0;
    $stmt = mysqli_prepare($conn, "INSERT INTO user (first_name, last_name, email, user_name, password) VALUES (?, ?, ?, ?, ?)");
    
    for ($i = 1; $i <= $userCount; $i++) {
        $firstName = $firstNames[array_rand($firstNames)];
        $lastName = $lastNames[array_rand($lastNames)];
        $domain = $domains[array_rand($domains)];
        
        $username = strtolower($firstName . $lastName . rand(100, 9999));
        $email = strtolower($firstName . '.' . $lastName . rand(10, 999) . '@' . $domain);
        $password = md5('password123');
        
        mysqli_stmt_bind_param($stmt, "sssss", $firstName, $lastName, $email, $username, $password);
        
        if (mysqli_stmt_execute($stmt)) {
            $successCount++;
        }
        
        $progress = ($i / $userCount) * 100;
        echo "<script>
                document.getElementById('progress-bar').style.width = '$progress%';
                document.getElementById('progress-text').innerHTML = 'Generated $i of $userCount users ($progress%)';
              </script>";
        
        if ($i % 10 == 0) {
            echo "<script>document.body.scrollTop = document.documentElement.scrollTop = document.body.scrollHeight;</script>";
            flush();
        }
    }
    
    mysqli_stmt_close($stmt);
    mysqli_commit($conn);
    
    echo "<div class='success center-align'>";
    echo "<h4><i class='material-icons left'>check_circle</i>Success!</h4>";
    echo "<p>Successfully generated <strong>$successCount</strong> users out of <strong>$userCount</strong> requested.</p>";
    echo "</div>";
    
    echo "<div class='center-align' style='margin: 30px 0;'>";
    echo "<a href='table.php' class='btn waves-effect waves-light'>";
    echo "<i class='material-icons left'>people</i>View All Users";
    echo "</a>";
    echo "<a href='bulk_user_generator.php' class='btn waves-effect waves-light grey'>";
    echo "<i class='material-icons left'>refresh</i>Generate More";
    echo "</a>";
    echo "<a href='welcomepage.php' class='btn waves-effect waves-light blue'>";
    echo "<i class='material-icons left'>home</i>Dashboard";
    echo "</a>";
    echo "</div>";
    
} catch (Exception $e) {
    mysqli_rollback($conn);
    echo "<div class='error'>";
    echo "<h4>Error: " . $e->getMessage() . "</h4>";
    echo "</div>";
}

echo "</div></div></div></div></div>";
echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js'></script>";
echo "</body></html>";

mysqli_close($conn);
?>
