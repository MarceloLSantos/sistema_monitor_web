<div class="sidebar d-none d-md-block">
    <div class="sidebar-content">
        <a class="d-block mb-3 text-center" href="#"><img src="./img/logo_empresa.png" alt="Logo" width="100"></a>
        <h5 class="text-center mb-3">Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'cadastro_proposta') ? 'active' : ''; ?>" href="index.php?page=cadastro_proposta">Cadastro de Proposta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'atualizar_proposta') ? 'active' : ''; ?>" href="index.php?page=atualizar_proposta">Atualizar Proposta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'listar_propostas') ? 'active' : ''; ?>" href="index.php?page=listar_propostas">Acompanhar Propostas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'logout') ? 'active' : ''; ?>" href="index.php?page=logout">Logout</a>
            </li>
        </ul>
        <footer class="text-center text-muted bg-light">
            Desenvolvido por<br>MLS Sistemas (2025)<br>Versão 1.0
        </footer>
    </div>
</div>
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMobile" aria-labelledby="sidebarMobileLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarMobileLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <a class="d-block mb-3 text-center" href="#"><img src="./img/logo_empresa.png" alt="Logo" width="100"></a>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'cadastro_proposta') ? 'active' : ''; ?>" href="index.php?page=cadastro_proposta">Cadastro de Proposta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'atualizar_proposta') ? 'active' : ''; ?>" href="index.php?page=atualizar_proposta">Atualizar Proposta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'listar_propostas') ? 'active' : ''; ?>" href="index.php?page=listar_propostas">Acompanhar Propostas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($_GET['page'] == 'logout') ? 'active' : ''; ?>" href="index.php?page=logout">Logout</a>
            </li>
        </ul>
        <footer class="text-center text-muted bg-light">
            Desenvolvido por<br>MLS Sistemas (2025)<br>Versão 1.0
        </footer>
    </div>
</div>