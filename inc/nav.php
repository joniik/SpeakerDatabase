<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">SpeakerDatabase</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="elementit.php">Database elementeistä</a>
        </li>
      </ul>

      <!-- Search form -->
      <form class="d-flex me-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Hae" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Hae</button>
      </form>

      <!-- Conditional display of buttons -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- When logged in, show the Log Out button -->
        <a href="logout.php" class="btn btn-outline-danger">Kirjaudu ulos</a>
      <?php else: ?>
        <!-- When not logged in, show the Login and Register buttons -->
        <a href="login.php" class="btn btn-outline-primary me-2">Kirjaudu</a>
        <a href="register.php" class="btn btn-outline-secondary">Rekisteröidy</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
