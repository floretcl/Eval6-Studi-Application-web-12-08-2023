<header>
    <nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand mb-0 h1 font-monospace" href="?controller=administration">KGB : missions</a>
            <div class="d-flex flex-row flex-wrap align-items-center">
            <span class="navbar-text me-2">
              Hello, <?= htmlspecialchars($currentAdmin->getFirstName()) . ' ' . htmlspecialchars($currentAdmin->getLastName()) ?> |
            </span>
                <a class="nav-link link-light me-3" href="/" target="_blank">Go on website</a>
                <a class="btn btn-sm btn-outline-secondary font-monospace" href="?controller=auth&action=login">Logout</a>
            </div>
        </div>
    </nav>
</header>