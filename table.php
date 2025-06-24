<?php
include('session.php');
include('header.php');
include('navigation.php');
include('conn.php');

// Pagination
$start = @$_GET['start'] ?? 0;
$end = @$_GET['end'] ?? 10;
$search = @$_GET['search'] ?? '';

// Search query
$searchCondition = '';
if (!empty($search)) {
    $searchCondition = "WHERE first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR email LIKE '%$search%' OR user_name LIKE '%$search%'";
}

$rawQuery = "SELECT * FROM user $searchCondition LIMIT $start, $end";
$records = mysqli_query($conn, $rawQuery);

// Count total records
$countQuery = "SELECT COUNT(*) as total FROM user $searchCondition";
$countResult = mysqli_query($conn, $countQuery);
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / 10);
?>

<div class="container">
    <!-- Header Section -->
    <div class="row" style="margin-top: 30px;">
        <div class="col s12">
            <div class="card" style="background: linear-gradient(135deg, var(--accent-purple), var(--accent-light)); border: none;">
                <div class="card-content white-text center-align">
                    <i class="material-icons large">group</i>
                    <h4 style="margin: 20px 0 10px 0; color: white;">User Management System</h4>
                    <p style="color: rgba(255,255,255,0.9); font-size: 18px;">Manage all registered users and their information</p>
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
                            <form action="table.php" method="GET" class="row" style="margin-bottom: 0;">
                                <div class="input-field col s12 m8">
                                    <i class="material-icons prefix">search</i>
                                    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($search); ?>">
                                    <label for="search">Search users by name, email, or username</label>
                                </div>
                                <div class="col s12 m4" style="margin-top: 20px;">
                                    <button type="submit" class="btn waves-effect waves-light" style="margin-right: 10px;">
                                        <i class="material-icons left">search</i>Search
                                    </button>
                                    <a href="table.php" class="btn-secondary btn waves-effect waves-light">
                                        <i class="material-icons left">clear</i>Clear
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col s12 m4 right-align" style="margin-top: 20px;">
                            <a href="regestration.php" class="btn waves-effect waves-light">
                                <i class="material-icons left">person_add</i>Add New User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col s12">
            <div class="card hoverable">
                <div class="card-content">
                    <span class="card-title">
                        <i class="material-icons left">people</i>Registered Users
                        <span class="right" style="font-size: 14px; color: var(--text-secondary);">
                            Total: <?php echo $totalRecords; ?> users
                        </span>
                    </span>

                    <div class="responsive-table-container" style="margin-top: 20px;">
                        <table class="striped responsive-table highlight">
                            <thead>
                                <tr>
                                    <th><i class="material-icons left tiny">tag</i>ID</th>
                                    <th><i class="material-icons left tiny">person</i>Name</th>
                                    <th><i class="material-icons left tiny">email</i>Email</th>
                                    <th><i class="material-icons left tiny">account_circle</i>Username</th>
                                    <th><i class="material-icons left tiny">date_range</i>Joined</th>
                                    <th><i class="material-icons left tiny">settings</i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($records) > 0) {
                                    while ($row = mysqli_fetch_array($records)) {
                                ?>
                                <tr class="user-row" data-user-id="<?php echo $row['id']; ?>">
                                    <td>
                                        <span class="badge" style="background: var(--accent-light);">
                                            <?php echo $row['id']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <strong><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></strong>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="email-text"><?php echo htmlspecialchars($row['email']); ?></span>
                                    </td>
                                    <td>
                                        <span class="username-text">@<?php echo htmlspecialchars($row['user_name']); ?></span>
                                    </td>
                                    <td>
                                        <span class="date-text">
                                            <?php echo isset($row['created_at']) ? date('M d, Y', strtotime($row['created_at'])) : 'N/A'; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="btn-small waves-effect waves-light tooltipped"
                                               data-tooltip="View Profile" data-position="top">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="#" class="btn-small waves-effect waves-light orange tooltipped"
                                               data-tooltip="Edit User" data-position="top">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#" class="btn-small waves-effect waves-light red tooltipped delete-user"
                                               data-tooltip="Delete User" data-position="top" data-user-id="<?php echo $row['id']; ?>">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="center-align" style="padding: 40px;">
                                            <i class="material-icons large" style="color: var(--text-secondary);">people_outline</i>
                                            <p style="color: var(--text-secondary); margin-top: 20px;">No users found</p>
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
                            <a href="<?php echo ($start <= 0) ? '#' : 'table.php?start='.($start-10).'&end='.$end.'&search='.urlencode($search); ?>">
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
                                <a href="table.php?start=<?php echo $pageStart; ?>&end=<?php echo $pageEnd; ?>&search=<?php echo urlencode($search); ?>">
                                    <?php echo ($i + 1); ?>
                                </a>
                            </li>
                        <?php } ?>

                        <li class="<?php echo ($start >= ($totalPages-1)*10) ? 'disabled' : 'waves-effect'; ?>">
                            <a href="<?php echo ($start >= ($totalPages-1)*10) ? '#' : 'table.php?start='.($start+10).'&end='.$end.'&search='.urlencode($search); ?>">
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
.user-row {
    transition: all 0.3s ease;
}

.user-row:hover {
    background: var(--glass-bg) !important;
    transform: translateX(5px);
}

.action-buttons {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
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
    padding: 4px 8px;
    border-radius: 12px;
    color: white;
    font-size: 12px;
    font-weight: 500;
}

.user-info strong {
    color: var(--text-primary);
}

.email-text {
    color: var(--accent-light);
    font-size: 14px;
}

.username-text {
    color: var(--text-secondary);
    font-style: italic;
}

.date-text {
    color: var(--text-secondary);
    font-size: 13px;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltips = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltips);

    // Initialize sidenav
    var sidenavs = document.querySelectorAll('.sidenav');
    M.Sidenav.init(sidenavs);

    // Delete user confirmation
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const userId = this.getAttribute('data-user-id');

            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                // Here you would implement the delete functionality
                console.log('Delete user with ID:', userId);
                // You can add AJAX call here to delete the user
            }
        });
    });

    // Animate rows on load
    const rows = document.querySelectorAll('.user-row');
    rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';

        setTimeout(() => {
            row.style.transition = 'all 0.5s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<?php include('footer.php'); ?>