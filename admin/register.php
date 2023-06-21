<?php

include '../components/connect.php';

if (isset($_POST['submit'])) {

   $id = uniqid();

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = uniqid() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/' . $rename;

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
   $select_tutor->execute([$email]);

   if ($select_tutor->rowCount() > 0) {
      $message[] = 'E-mail já registrado!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Confirmação de senha não corresponde!';
      } else {
         $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
         $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);
         $message[] = 'Novo tutor registrado! Faça o login agora';
      }
   }

}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cadastro</title>
   <!-- Font Awesome CDN link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- Custom CSS file link -->
   <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body style="padding-left: 0;">
   <?php
   if (isset($message)) {
      foreach ($message as $message) {
         echo '
      <div class="message form">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
      }
   }
   ?>
   <!-- Seção de cadastro começa aqui  -->
   <section class="form-container">
      <form class="register" action="" method="post" enctype="multipart/form-data">
         <h3>Cadastrar novo</h3>
         <div class="flex">
            <div class="col">
               <p>Seu nome <span>*</span></p>
               <input type="text" name="name" placeholder="Digite seu nome" maxlength="50" required class="box">
               <p>Sua profissão <span>*</span></p>
               <select name="profession" class="box" required>
                  <option value="" disabled selected>-- selecione sua profissão</option>
                  <option value="desenvolvedor">desenvolvedor</option>
                  <option value="designer">designer</option>
                  <option value="músico">músico</option>
                  <option value="biólogo">biólogo</option>
                  <option value="professor">professor</option>
                  <option value="engenheiro">engenheiro</option>
                  <option value="advogado">advogado</option>
                  <option value="médico">médico</option>
                  <option value="jornalista">jornalista</option>
                  <option value="fotógrafo">fotógrafo</option>
               </select>
               <p>Seu e-mail <span>*</span></p>
               <input type="email" name="email" placeholder="Digite seu e-mail" maxlength="20" required class="box">
            </div>
            <div class="col">
               <p>Sua senha <span>*</span></p>
               <input type="password" name="pass" placeholder="Digite sua senha" maxlength="20" required class="box">
               <p>Confirme sua senha <span>*</span></p>
               <input type="password" name="cpass" placeholder="Confirme sua senha" maxlength="20" required class="box">
               <p>Selecione uma foto <span>*</span></p>
               <input type="file" name="image" accept="image/*" required class="box">
            </div>
         </div>
         <p class="link">Já possui uma conta? <a href="login.php">Faça o login agora</a></p>
         <input type="submit" name="submit" value="Cadastrar agora" class="btn">
      </form>
   </section>
   <!-- Seção de cadastro termina aqui -->
   <script>
      let darkMode = localStorage.getItem('dark-mode');
      let body = document.body;

      const enableDarkMode = () => {
         body.classList.add('dark');
         localStorage.setItem('dark-mode', 'enabled');
      }

      const disableDarkMode = () => {
         body.classList.remove('dark');
         localStorage.setItem('dark-mode', 'disabled');
      }

      if (darkMode === 'enabled') {
         enableDarkMode();
      } else {
         disableDarkMode();
      }
   </script>
</body>
</html>
