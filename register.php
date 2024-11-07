<?php
session_start();
include_once 'inc/header.php';
require_once 'inc/database.php';

$usernameError = $passwordError = $confirmPasswordError = $registrationError = '';

// Process the registration form submission
if (!empty($_POST)) {
    // Retrieve and sanitize the input
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
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
    if (empty($confirmPassword)) {
        $valid = false;
        $confirmPasswordError = "Vahvista salasana";
    } elseif ($password !== $confirmPassword) {
        $valid = false;
        $confirmPasswordError = "Salasanat eivät täsmää";
    }

    // If the form is valid, proceed with storing the new user
    if ($valid) {
        // Check if the username already exists
        $sql = "SELECT id FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $userExists = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userExists) {
            $registrationError = "Käyttäjätunnus on jo käytössä";
        } else {
            // Hash the password and insert the new user
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password_hash', $passwordHash);

            if ($stmt->execute()) {
                // Registration successful, redirect to the login page
                header("Location: login.php");
                exit;
            } else {
                $registrationError = "Rekisteröinti epäonnistui, yritä uudelleen";
            }
        }
    }
}

?>

<div class="row">
  <div class="col-8 mx-auto">
    <div class="card card-body bg-light mt-3">
      <h3>Rekisteröidy</h3>

      <form method="post" class="needs-validation" novalidate>

        <div class="mb-3">
          <label for="username" class="form-label">Käyttäjätunnus</label>
          <input type="text" 
                 class="form-control <?php echo (!empty($usernameError)) ? 'is-invalid' : ''; ?>" 
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
                 class="form-control <?php echo (!empty($passwordError)) ? 'is-invalid' : ''; ?>" 
                 id="password" 
                 name="password" 
                 required>
          <div class="invalid-feedback">
            <small><?php echo $passwordError; ?></small>
          </div>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Vahvista salasana</label>
          <input type="password" 
                 class="form-control <?php echo (!empty($confirmPasswordError)) ? 'is-invalid' : ''; ?>" 
                 id="confirm_password" 
                 name="confirm_password" 
                 required>
          <div class="invalid-feedback">
            <small><?php echo $confirmPasswordError; ?></small>
          </div>
        </div>

        <?php if (!empty($registrationError)): ?>
          <div class="alert alert-danger"><?php echo $registrationError; ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Rekisteröidy</button>
        <p class="mt-3">Onko sinulla jo tili? <a href="login.php">Kirjaudu sisään täällä</a>.</p>
      </form>
    </div>
  </div>
</div>

<?php include_once 'inc/footer.php'; ?>
