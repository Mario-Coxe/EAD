<?php
   //CONEXAO
   $db_name = 'mysql:host=localhost;dbname=cursos';
   $user_name = 'root';
   $user_password = 'computacao';
   
   $conn = new PDO($db_name, $user_name, $user_password);
?>