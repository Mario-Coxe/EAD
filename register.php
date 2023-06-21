<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['submit'])) {

   $id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/' . $rename;

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);

   if ($select_user->rowCount() > 0) {
      $message[] = 'Email já cadastrado!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirmação de senha não coincide!';
      } else {
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image) VALUES(?,?,?,?,?)");
         $insert_user->execute([$id, $name, $email, $cpass, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);

         $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
         $verify_user->execute([$email, $pass]);
         $row = $verify_user->fetch(PDO::FETCH_ASSOC);

         if ($verify_user->rowCount() > 0) {
            setcookie('user_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
            header('location:index.php');
         }
      }
   }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Início</title>
   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- Link para o arquivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'components/user_header.php'; ?>
   <section class="form-container">
      <form class="register" action="" method="post" enctype="multipart/form-data">
         <h3>Criar conta</h3>
         <div class="flex">
            <div class="col">
               <p>Seu nome <span>*</span></p>
               <input type="text" name="name" placeholder="Digite seu nome" maxlength="50" required class="box">
               <p>Seu e-mail <span>*</span></p>
               <input type="email" name="email" placeholder="Digite seu e-mail" maxlength="20" required class="box">
            </div>
            <div class="col">
               <p>Sua senha <span>*</span></p>
               <input type="password" name="pass" placeholder="Digite sua senha" maxlength="20" required class="box">
               <p>Confirme a senha <span>*</span></p>
               <input type="password" name="cpass" placeholder="Confirme sua senha" maxlength="20" required class="box">
            </div>
         </div>
         <p>Selecione uma imagem <span>*</span></p>
         <input type="file" name="image" accept="image/*" required class="box">
         <p class="link">Já tem uma conta? <a href="login.php">Faça login agora</a></p>
         <input type="submit" name="submit" value="Registrar agora" class="btn">
      </form>
   </section>
   <?php include 'components/footer.php'; ?>
   <!-- Link para o arquivo JS personalizado -->
   <script src="js/script.js"></script>
</body>

</html>