<nav class="navbar navbar-expand-lg bg-custom-color">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 1 ? 'active' : '' ?>" aria-current="page" href="?page=1">TESTS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 2 ? 'active' : '' ?>" href="?page=2">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 3 ? 'active' : '' ?>" href="?page=3">ADMIN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <? echo $page == 4 ? 'active' : '' ?>" href="?page=4">REGISTRATION</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <? if (!isset($_SESSION['login'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link <? echo $page == 5 ? 'active' : '' ?>" href="?page=5">LOG IN</a>
                    </li>
                <? } else { ?>
                    <? if (isset($_SESSION['login'])) { ?>
                        <li class="nav-item">
                            <p class='nav-link navbar-text' style='margin-bottom: 0;color: white;'>Hello, <? echo $_SESSION['login'] ?></p>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <? echo $page == 6 ? 'active' : '' ?>" href="?page=6">LOG OUT</a>
                        </li>
                <? }
                } ?>

            </ul>
        </div>
    </div>
</nav>