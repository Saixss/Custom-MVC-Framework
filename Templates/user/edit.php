<?php /** @var src\DTO\ErrorDTO $error */?>
<?php /** @var src\DTO\User\UserDTO[] $data */ ?>
<h2>Edit Profile</h2>
<?php if (isset($error)) : ?>
    <p style="color:red"><?= $error->getMessage() ?></p>
<?php endif; ?>
<form method="post">
    <?php foreach ($data as $user): ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" value="<?= $user->getUsername(); ?>" id="username" placeholder="Username"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Password"/>
        </div>
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" value="<?= $user->getFirstName(); ?>" id="first_name" placeholder="First Name"/>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" value="<?= $user->getLastName(); ?>" id="last_name" placeholder="Last Name"/>
        </div>
        <input type="submit" class="btn btn-primary"  name="btnEdit" value="Edit" />
        <a href="../" class="btn btn-primary">Back</a>
    <?php endforeach; ?>
</form>
