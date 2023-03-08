<?php
// Connect to MySQL database
$host = 'localhost';
$user = 'username';
$password = 'password';
$dbname = 'database_name';
$conn = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) {
  die('Connection failed: ' . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['submit'])) {
  $action = $_POST['action'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $id = $_POST['id'];

  if ($action == 'create') {
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
      $message = "User created successfully";
    } else {
      $error = "Error creating user: " . mysqli_error($conn);
    }
  } else if ($action == 'update') {
    $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
      $message = "User updated successfully";
    } else {
      $error = "Error updating user: " . mysqli_error($conn);
    }
  } else if ($action == 'delete') {
    $sql = "DELETE FROM users WHERE id=$id";
    if (mysqli_query($conn, $sql)) {
      $message = "User deleted successfully";
    } else {
      $error = "Error deleting user: " . mysqli_error($conn);
    }
  }
}

// Retrieve user data
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>CRUD Example</title>
</head>
<body>
  <?php if (isset($message)): ?>
    <div><?php echo $message; ?></div>
  <?php endif; ?>
  <?php if (isset($error)): ?>
    <div><?php echo $error; ?></div>
  <?php endif; ?>

  <h1>Users</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['email']; ?></td>
          <td><?php echo $row['password']; ?></td>
          <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            <form method="post" style="display: inline-block;">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="action" value="delete">
              <button type="submit">Delete</button>
            </form>
      </tr>
    </tbody>
  </table>
  <h2>Create User</h2>
  <form method="post">
    <input type="hidden" name="action" value="create">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br>
    <label>Email:</label>
    <input type="email" name="email" required>
    <br>
    <label>Password:</label>
    <input type="password" name="password" required>
    <br>
    <button type="submit" name="submit">Create</button>
  </form>
</body>
</html> 