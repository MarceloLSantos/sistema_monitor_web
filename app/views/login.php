<!-- ### app/views/login.php -->
<?php include 'layouts/main.php'; ?>
<div class="container-fluid mt-4">
    <h3 class="text-center fw-bold text-dark text-opacity-50">LOGIN</h3>
    <form method="post" class="w-50 mx-auto">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    </form>
</div>
<?php include 'app/views/layouts/footer.php'; ?>