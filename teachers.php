<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Professores</title>
   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- Link para o arquivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'components/user_header.php'; ?>
   <!-- Seção de professores começa aqui -->
   <section class="teachers">
      <h1 class="heading">Professores especializados</h1>
      <form action="search_tutor.php" method="post" class="search-tutor">
         <input type="text" name="search_tutor" maxlength="100" placeholder="buscar professor..." required>
         <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
      </form>
      <div class="box-container">
         <div class="box offer">
            <h3>Torne-se um professor</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, magnam!</p>
            <a href="admin/register.php" class="inline-btn">Comece agora</a>
         </div>

         <?php
         $select_tutors = $conn->prepare("SELECT * FROM `tutors`");
         $select_tutors->execute();
         if ($select_tutors->rowCount() > 0) {
            while ($fetch_tutor = $select_tutors->fetch(PDO::FETCH_ASSOC)) {

               $tutor_id = $fetch_tutor['id'];

               $count_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
               $count_playlists->execute([$tutor_id]);
               $total_playlists = $count_playlists->rowCount();

               $count_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
               $count_contents->execute([$tutor_id]);
               $total_contents = $count_contents->rowCount();

               $count_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
               $count_likes->execute([$tutor_id]);
               $total_likes = $count_likes->rowCount();

               $count_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
               $count_comments->execute([$tutor_id]);
               $total_comments = $count_comments->rowCount();
               ?>
               <div class="box">
                  <div class="tutor">
                     <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
                     <div>
                        <h3>
                           <?= $fetch_tutor['name']; ?>
                        </h3>
                        <span>
                           <?= $fetch_tutor['profession']; ?>
                        </span>
                     </div>
                  </div>
                  <p>Playlists: <span>
                        <?= $total_playlists; ?>
                     </span></p>
                  <p>Total de vídeos: <span>
                        <?= $total_contents ?>
                     </span></p>
                  <p>Total de curtidas: <span>
                        <?= $total_likes ?>
                     </span></p>
                  <p>Total de comentários: <span>
                        <?= $total_comments ?>
                     </span></p>
                  <form action="tutor_profile.php" method="post">
                     <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
                     <input type="submit" value="Ver perfil" name="tutor_fetch" class="inline-btn">
                  </form>
               </div>
               <?php
            }
         } else {
            echo '<p class="empty">Nenhum professor encontrado!</p>';
         }
         ?>
      </div>
   </section>
   <!-- Seção de professores termina aqui -->
   <?php include 'components/footer.php'; ?>
   <!-- Link para o arquivo JS personalizado -->
   <script src="js/script.js"></script>
</body>

</html>