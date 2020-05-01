<?php /** @var src\DTO\ErrorDTO $error */?>
<h2>Register</h2>
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
    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"/>
    </div>
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" placeholder="First Name"/>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" placeholder="Last Name"/>
    </div>
    <input type="submit" class="btn btn-primary"  name="btnRegister" value="Register" />
    <a href="../" class="btn btn-primary">Back</a>
</form>

