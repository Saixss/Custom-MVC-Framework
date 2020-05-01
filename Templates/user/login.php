<?php /** @var src\DTO\ErrorDTO $error */?>
<h2>Login</h2>
<?php if (isset($error)) : ?>
    <p style="color:red"><?= $error->getMessage() ?></p>
<?php endif; ?>
<form method="post">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" placeholder="Username"/>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Password"/>
    </div>
    <input type="submit" class="btn btn-primary"  name="btnLogin" value="Login" />
    <a href="../" class="btn btn-primary">Back</a>
</form>
