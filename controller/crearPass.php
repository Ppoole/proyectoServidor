<?php


$password = 'patatafrita';

//Hash it with BCRYPT.
$passwordHashed = password_hash($password, PASSWORD_BCRYPT);

//Print it out.
echo $passwordHashed;