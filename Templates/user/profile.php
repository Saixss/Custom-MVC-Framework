<?php /** @var array $data */ ?>
<?php /** @var src\DTO\User\UserDTO $user */ $user = $data[0]?>
<h2>Profile</h2><br>
<h3>Username: <?= $user->getUsername() ?></h3>
<h3>First Name: <?= $user->getFirstName() ?></h3>
<h3>Last Name: <?= $user->getLastName() ?></h3>
<a href="../" class="btn btn-primary">Back</a>
