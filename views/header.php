<header>
    <div class="logo">
        <img src="https://www.lachacrafutbol.com.ar/web/wp-content/uploads/2023/02/previewiso-futbollch.svg" alt="La Chacra Fútbol Logo" width="100" height="100">
    </div>

    <div class="user-section">
        <div>Hola, <?= htmlspecialchars($_SESSION['usuario']) ?></div>
        <a href="logout.php" class="logout-btn">Cerrar sesión</a>
    </div>
</header>
