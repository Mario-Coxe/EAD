<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
   header('location:login.php');
}

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE user_id = ?");
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
$select_bookmark->execute([$user_id]);
$total_bookmarked = $select_bookmark->rowCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Perfil</title>
   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- Link para o arquivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'components/user_header.php'; ?>
   <section class="profile">
      <h1 class="heading">Detalhes do perfil</h1>
      <div class="details">
         php
         Copy code
         <div class="user">
            <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
            <h3>
               <?= $fetch_profile['name']; ?>
            </h3>
            <p>Estudante</p>
            <a href="update.php" class="inline-btn">Atualizar perfil</a>
         </div>

         <div class="box-container">

            <div class="box">
               <div class="flex">
                  <i class="fas fa-bookmark"></i>
                  <div>
                     <h3>
                        <?= $total_bookmarked; ?>
                     </h3>
                     <span>Playlists salvas</span>
                  </div>
               </div>
               <a href="#" class="inline-btn">Ver playlists</a>
            </div>

            <div class="box">
               <div class="flex">
                  <i class="fas fa-heart"></i>
                  <div>
                     <h3>
                        <?= $total_likes; ?>
                     </h3>
                     <span>Tutoriais curtidos</span>
                  </div>
               </div>
               <a href="#" class="inline-btn">Ver curtidas</a>
            </div>

            <div class="box">
               <div class="flex">
                  <i class="fas fa-comment"></i>
                  <div>
                     <h3>
                        <?= $total_comments; ?>
                     </h3>
                     <span>Comentários em vídeos</span>
                  </div>
               </div>
               <a href="#" class="inline-btn">Ver comentários</a>
            </div>

         </div>
      </div>
   </section>
   <!-- Seção do rodapé -->
   <footer class="footer">
      © Direitos autorais de 2022 por <span>Mr. Web Designer</span> | Todos os direitos reservados!

   </footer>
   <!-- Fim da seção do rodapé -->
   <!-- Link para o arquivo JS personalizado -->
   <script src="js/script.js"></script>
</body>

</html>