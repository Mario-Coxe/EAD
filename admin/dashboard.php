<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
   $tutor_id = $_COOKIE['tutor_id'];
} else {
   $tutor_id = '';
   header('location:login.php');
}

$select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
$select_contents->execute([$tutor_id]);
$total_contents = $select_contents->rowCount();

$select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
$select_playlists->execute([$tutor_id]);
$total_playlists = $select_playlists->rowCount();

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
$select_likes->execute([$tutor_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
$select_comments->execute([$tutor_id]);
$total_comments = $select_comments->rowCount();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Painel de Controle</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
   <?php include '../components/admin_header.php'; ?>
   <section class="dashboard">
      <h1 class="heading">Painel de Controle</h1>
      <div class="box-container">
         <div class="box">
            <h3>Bem-vindo(a)!</h3>
            <p>
               <?= $fetch_profile['name']; ?>
            </p>
            <a href="profile.php" class="btn">Ver perfil</a>
         </div>

         <div class="box">
            <h3>
               <?= $total_contents; ?>
            </h3>
            <p>Total de conteúdos</p>
            <a href="add_content.php" class="btn">Adicionar novo conteúdo</a>
         </div>

         <div class="box">
            <h3>
               <?= $total_playlists; ?>
            </h3>
            <p>Total de playlists</p>
            <a href="add_playlist.php" class="btn">Adicionar nova playlist</a>
         </div>

         <div class="box">
            <h3>
               <?= $total_likes; ?>
            </h3>
            <p>Total de curtidas</p>
            <a href="contents.php" class="btn">Ver conteúdos</a>
         </div>

         <div class="box">
            <h3>
               <?= $total_comments; ?>
            </h3>
            <p>Total de comentários</p>
            <a href="comments.php" class="btn">Ver comentários</a>
         </div>

         <div class="box">
            <h3>Seleção rápida</h3>
            <p>Login ou registro</p>
            <div class="flex-btn">
               <a href="login.php" class="option-btn">Login</a>
               <a href="register.php" class="option-btn">Registro</a>
            </div>
         </div>
      </div>
   </section>
   <?php include '../components/footer.php'; ?>
   <script src="../js/admin_script.js"></script>
</body>

</html>