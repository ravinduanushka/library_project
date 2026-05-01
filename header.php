<header>
    <h2 class="logo">Library</h2>

    <nav class="navigation">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Service</a>
        <a href="#">Contact</a>

        <?php if (isset($_SESSION['email'])) { ?>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Logout</a>
        <?php } else { ?>
            <button type="button" class="btnLogin" onclick="openPopup()">Login</button>
        <?php } ?>
    </nav>
</header>

<script>
function openPopup() {
    var wrapper = document.getElementById('popupWrapper');
    if (wrapper) {
        wrapper.style.display = 'block';
        showLogin();
    }
}

function closePopup() {
    var wrapper = document.getElementById('popupWrapper');
    if (wrapper) {
        wrapper.style.display = 'none';
    }
}

function showRegister() {
    event.preventDefault();
    document.getElementById('loginForm').classList.remove('active');
    document.getElementById('registerForm').classList.add('active');
}

function showLogin() {
    if (event) event.preventDefault();
    document.getElementById('registerForm').classList.remove('active');
    document.getElementById('loginForm').classList.add('active');
}
</script>