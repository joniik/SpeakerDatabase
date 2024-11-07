<?php
session_start();
include_once 'inc/header.php';
require_once 'inc/database.php';

$usernameError = $passwordError = $loginError = '';

// Process the login form submission
if (!empty($_POST)) {
    // Retrieve and sanitize the input
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $valid = true;

    // Validate input
    if (empty($username)) {
        $valid = false;
        $usernameError = "Syötä käyttäjätunnus";
    }
    if (empty($password)) {
        $valid = false;
        $passwordError = "Syötä salasana";
    }

    // If input is valid, check credentials
    if ($valid) {
        // Query to find the user by username
        $sql = "SELECT id, username, password_hash FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password_hash'])) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: elementit.php"); // Redirect to the main page
            exit;
        } else {
            // Login failed
            $loginError = "Käyttäjätunnus tai salasana on virheellinen";
        }
    }
}

?>

<div class="row">
  <div class="col-8 mx-auto">
    <div class="card card-body bg-light mt-3">
      <h3>Kirjaudu sisään</h3>

      <form method="post" class="needs-validation" novalidate>

        <div class="mb-3">
          <label for="username" class="form-label">Käyttäjätunnus</label>
          <input type="text" 
                 class="form-control <?php echo (!empty($usernameError) || !empty($loginError)) ? 'is-invalid' : ''; ?>" 
                 id="username" 
                 name="username" 
                 value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                 required>
          <div class="invalid-feedback">
            <small><?php echo $usernameError; ?></small>
          </div>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Salasana</label>
          <input type="password" 
                 class="form-control <?php echo (!empty($passwordError) || !empty($loginError)) ? 'is-invalid' : ''; ?>" 
                 id="password" 
                 name="password" 
                 required>
          <div class="invalid-feedback">
            <small><?php echo $passwordError; ?></small>
          </div>
        </div>

        <?php if (!empty($loginError)): ?>
          <div class="alert alert-danger"><?php echo $loginError; ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Kirjaudu sisään</button>
        <p class="mt-3">Eikö sinulla ole vielä tiliä? <a href="register.php">Rekisteröidy täällä</a>.</p>
      </form>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>
