<?php
// Include the database connection
include '../config/db.php'; // Adjust path as necessary

// SQL to fetch all user accounts
$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch the results
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HTML to display the account list -->
<table class="account-table">
    <thead>
        <tr>
            <th>#</th>
            <th>ID</th>
            <th>Picture</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Username</th>
            <th>Password</th>
            <th>Created At</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody class="account-list">
        <?php foreach ($accounts as $account): ?>
        <tr data-id="<?php echo $account['user_id']; ?>">
            <td><?php echo $account['user_id']; ?></td>
            <td><?php echo $account['teacher_id']; ?></td>
            <td><img src="uploads/<?php echo $account['picture']; ?>" alt="User Picture" width="50"></td>
            <td><?php echo $account['teacher_name']; ?></td>
            <td><?php echo $account['role']; ?></td>
            <td><?php echo $account['username']; ?></td>
            <td><?php echo $account['password']; ?></td>
            <td><?php echo $account['created_at']; ?></td>
            <td><button type="button" class="edit-btn" onclick="editAccount(<?php echo $account['user_id']; ?>)">Edit</button></td>
            <td><button type="button" class="delete-btn" onclick="deleteAccount(<?php echo $account['user_id']; ?>)">Delete</button></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
