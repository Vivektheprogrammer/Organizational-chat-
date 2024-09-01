<?php
include 'connect.php';

// Approve or Reject user registrations
if(isset($_POST['approve'])){
    $userId = $_POST['userId'];
    $sql = "UPDATE users SET approved=1 WHERE id=$userId";
    if($conn->query($sql) === TRUE){
        echo "User approved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

if(isset($_POST['reject'])){
    $userId = $_POST['userId'];
    $sql = "DELETE FROM users WHERE id=$userId";
    if($conn->query($sql) === TRUE){
        echo "User rejected successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch pending registrations
$sql = "SELECT * FROM users WHERE approved=0";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="approval.css">
    <title>User Approval</title>
</head>
<body>
    <h1>User Approval</h1>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['firstName']; ?></td>
            <td><?php echo $row['lastName']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="userId" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="approve">Approve</button>
                    <button type="submit" name="reject">Reject</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <a href="admin.php" style="text-decoration: none; color: blue; display: inline-block; padding: 10px 20px; background-color: #f0f0f0; border-radius: 5px;">Logout</a>
    </div>
</body>
</html>
