<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_contact->execute([$name, $email, $number, $msg]);

   if ($select_contact->rowCount() > 0) {
      $message[] = 'mensagem já enviada!';
   } else {
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $number, $msg]);
      $message[] = 'mensagem enviada com sucesso!';
   }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contato</title>
   <!-- link para o CDN do Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <!-- link para o arquivo CSS personalizado -->
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'components/user_header.php'; ?>
   <!-- seção de contato começa  -->
   <section class="contact">
      <div class="row">
         <div class="image">
            <img src="images/contact-img.svg" alt="">
         </div>

         <form action="" method="post">
            <h3>entre em contato</h3>
            <input type="text" placeholder="Digite seu nome" required maxlength="100" name="name" class="box">
            <input type="email" placeholder="Digite seu e-mail" required maxlength="100" name="email" class="box">
            <input type="number" min="0" max="9999999999" placeholder="Digite seu número" required maxlength="10"
               name="number" class="box">
            <textarea name="msg" class="box" placeholder="Digite sua mensagem" required cols="30" rows="10"
               maxlength="1000"></textarea>
            <input type="submit" value="enviar mensagem" class="inline-btn" name="submit">
         </form>
      </div>
      <div class="box-container">
         <div class="box">
            <i class="fas fa-phone"></i>
            <h3>número de telefone</h3>
            <a href="tel:922723380">922723380</a>
         </div>

         <div class="box">
            <i class="fas fa-envelope"></i>
            <h3>endereço de e-mail</h3>
            <a href="mailto:aluapjustino1@gmail.com">aluapjustino1@gmail.com</a>
         </div>

         <div class="box">
            <i class="fas fa-map-marker-alt"></i>
            <h3>endereço do escritório</h3>
            <a href="#">Sapú 2, Casas Verdes, Rua Da Pera, Casa Nº 45</a>
         </div>
      </div>
   </section>
   <!-- seção de contato termina -->
   <?php include 'components/footer.php'; ?>
   <!-- link para o arquivo JS personalizado -->
   <script src="js/script.js"></script>
</body>

</html>