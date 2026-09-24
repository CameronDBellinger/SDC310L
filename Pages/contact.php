<?php

require_once __DIR__ . "/../controller/connect_controller.php";
  
$message_sent = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = $_POST["fullname"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $stmt = $pdo->prepare("
        INSERT INTO contact_messages
        (full_name, email, subject, message)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $full_name,
        $email,
        $subject,
        $message
    ]);

    $message_sent = true;
}

require_once __DIR__ . "/../includes/header.php";

?>

<main>

<section class="contact-form container">

<h2>
Contact Us
</h2>

<?php if ($message_sent): ?>

<p>
Your message has been sent successfully.
</p>

<?php endif; ?>


<form method="POST">

<label for="fullname">
Full Name
</label>

<input
type="text"
id="fullname"
name="fullname"
required
>


<label for="email">
Email Address
</label>

<input
type="email"
id="email"
name="email"
required
>


<label for="subject">
Subject
</label>

<input
type="text"
id="subject"
name="subject"
>


<label for="message">
Message
</label>

<textarea
id="message"
name="message"
required
></textarea>


<button
type="submit"
class="button"
>
Send Message
</button>

</form>

</section>

</main>

<?php

require_once __DIR__ . "/../includes/footer.php";

?>
