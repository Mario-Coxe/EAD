<?php

include '../components/connect.php';

if(isset($_COOKIE['tutor_id'])){
   $tutor_id = $_COOKIE['tutor_id'];
}else{
   $tutor_id = '';
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $id = uniqid();
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $playlist = $_POST['playlist'];
   $playlist = filter_var($playlist, FILTER_SANITIZE_STRING);

   $thumb = $_FILES['thumb']['name'];
   $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
   $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
   $rename_thumb = uniqid().'.'.$thumb_ext;
   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../uploaded_files/'.$rename_thumb;

   $video = $_FILES['video']['name'];
   $video = filter_var($video, FILTER_SANITIZE_STRING);
   $video_ext = pathinfo($video, PATHINFO_EXTENSION);
   $rename_video = uniqid().'.'.$video_ext;
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $video_folder = '../uploaded_files/'.$rename_video;

   if($thumb_size > 2000000){
      $message[] = 'o tamanho da imagem é muito grande!';
   }else{
      $add_playlist = $conn->prepare("INSERT INTO `content`(id, tutor_id, playlist_id, title, description, video, thumb, status) VALUES(?,?,?,?,?,?,?,?)");
      $add_playlist->execute([$id, $tutor_id, $playlist, $title, $description, $rename_video, $rename_thumb, $status]);
      move_uploaded_file($thumb_tmp_name, $thumb_folder);
      move_uploaded_file($video_tmp_name, $video_folder);
      $message[] = 'novo curso enviado!';
   }

   

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Painel de Controle</title>
   <!-- link do cdn do font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- link do arquivo CSS personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>
<?php include '../components/admin_header.php'; ?>
<section class="video-form">
   <h1 class="heading">enviar conteúdo</h1>
   <form action="" method="post" enctype="multipart/form-data">
      <p>status do vídeo <span>*</span></p>
      <select name="status" class="box" required>
         <option value="" selected disabled>-- selecione o status</option>
         <option value="ativo">ativo</option>
         <option value="inativo">inativo</option>
      </select>
      <p>título do vídeo <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="digite o título do vídeo" class="box">
      <p>descrição do vídeo <span>*</span></p>
      <textarea name="description" class="box" required placeholder="escreva a descrição" maxlength="1000" cols="30" rows="10"></textarea>
      <p>playlist do vídeo <span>*</span></p>
      <select name="playlist" class="box" required>
         <option value="" disabled selected>--selecione a playlist</option>
         <?php
         $select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
         $select_playlists->execute([$tutor_id]);
         if($select_playlists->rowCount() > 0){
            while($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)){
         ?>
         <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
         <?php
            }
         ?>
         <?php
         }else{
            echo '<option value="" disabled>não há playlists criadas ainda!</option>';
         }
         ?>
      </select>
      <p>selecione uma miniatura <span>*</span></p>
      <input type="file" name="thumb" accept="image/*" required class="box">
      <p>selecione um vídeo <span>*</span></p>
      <input type="file" name="video" accept="video/*" required class="box">
      <input type="submit" value="enviar vídeo" name="submit" class="btn">
   </form>
</section>
<?php include '../components/footer.php'; ?>
<script src="../js/admin_script.js"></script>
</body>
</html>