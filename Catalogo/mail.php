<?php
if (empty($_POST['token'])) {
	echo '<span class="notice">Error!</span>';
	exit;
}
if ($_POST['token'] != 'FsWga4&@f6aw') {
	echo '<span class="notice">Error!</span>';
	exit;
}

$name = $_POST['name'];
$from = $_POST['email'];
$phone = $_POST['phone'];
$subject = stripslashes(nl2br($_POST['subject']));
$message = stripslashes(nl2br($_POST['message']));

$headers = "From: Form Contact <$from>\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso 8859-1";

ob_start();
?>
Hola nombre!<br /><br />
<?php echo ucfirst($name); ?> te ha enviado un mensaje desde tu pagina web!
<br /><br />

Name: <?php echo ucfirst($name); ?><br />
Email: <?php echo $from; ?><br />
Phone: <?php echo $phone; ?><br />
Subject: <?php echo $subject; ?><br />
Message: <br /><br />
<?php echo $message; ?>
<br />
<br />
============================================================
<?php
$body = ob_get_contents();
ob_end_clean();

$to = 'r0berto0@hotmail.com';

$s = mail($to, $subject, $body, $headers, "-t -i -f $from");

if ($s == 1) {
	echo '<div class="success"><i class="fas fa-check-circle"></i><h3>¡Gracias!</h3>¡Su mensaje ha sido enviado correctamente.</div>';
} else {
	echo '<div>El envio de su mensaje falló!</div>';
}
?>