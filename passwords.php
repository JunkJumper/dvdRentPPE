<?php

echo "cryptage de admin <br>";
echo password_hash("admin",PASSWORD_BCRYPT);
echo"<br>";
echo "cryptage de test<br>";
echo password_hash("test",PASSWORD_BCRYPT);
echo"<br>";
echo "cryptage de solo<br>";
echo password_hash("solo",PASSWORD_BCRYPT);
echo"<br>";
echo "cryptage de 12Notes<br>";
echo password_hash("12Notes",PASSWORD_BCRYPT);
echo"<br>";
echo "cryptage de toto<br>";
echo password_hash("toto",PASSWORD_BCRYPT);
echo "<br>";
echo "cryptage de sweet<br>";
echo password_hash("sweet",PASSWORD_BCRYPT);
echo "<br>";
?>





















?>