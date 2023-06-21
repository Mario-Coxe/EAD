<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
   $tutor_id = $_COOKIE['tutor_id'];
} else {
   $tutor_id = '';
   header('location:login.php');
}

if (isset($_POST['submit'])) {

   $id = uniqid();
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = uniqid() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/' . $rename;

   $add_playlist = $conn->prepare("INSERT INTO `playlist`(id, tutor_id, title, description, thumb, status) VALUES(?,?,?,?,?,?)");
   $add_playlist->execute([$id, $tutor_id, $title, $description, $rename, $status]);

   move_uploaded_file($image_tmp_name, $image_folder);

   $message[] = 'nova playlist criada!';

}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Adicionar Playlist</title>
   <!-- link do cdn do font awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- link do arquivo CSS personalizado -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
   <?php include '../components/admin_header.php'; ?>
   <section class="playlist-form">
      <h1 class="heading">criar playlist</h1>
      <form action="" method="post" enctype="multipart/form-data">
         <p>status da playlist <span>*</span></p>
         <select name="status" class="box" required>
            <option value="" selected disabled>-- selecione o status</option>
            <option value="ativo">ativo</option>
            <option value="inativo">inativo</option>
         </select>
         <p>título da playlist <span>*</span></p>
         <input type="text" name="title" maxlength="100" required placeholder="digite o título da playlist" class="box">
         <p>descrição da playlist <span>*</span></p>
         <textarea name="description" class="box" required placeholder="escreva a descrição" maxlength="1000" cols="30"
            rows="10"></textarea>
         <p>miniatura da playlist <span>*</span></p>
         <input type="file" name="image" accept="image/*" required class="box">
         <input type="submit" value="criar playlist" name="submit" class="btn">
      </form>
   </section>
   <?php include '../components/footer.php'; ?>
   <script src="../js/admin_script.js"></script>
</body>

</html>