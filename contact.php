<?php
// contact.php

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = htmlspecialchars(trim($_POST["name"]));
  $email = htmlspecialchars(trim($_POST["email"]));
  $inquiry_type = htmlspecialchars(trim($_POST["inquiry_type"]));
  $other_inquiry = htmlspecialchars(trim($_POST["other_inquiry"] ?? ''));
  $message = htmlspecialchars(trim($_POST["message"]));

  // If "Other" is selected, use the custom text
  if ($inquiry_type === "Other" && !empty($other_inquiry)) {
    $inquiry_type = "Other: " . $other_inquiry;
  }

  $to = "bottlesort.team@gmail.com";
  $subject = "New Contact Form Submission from $name";
  $body = "Name: $name\nEmail: $email\nInquiry Type: $inquiry_type\n\nMessage:\n$message";
  $headers = "From: $email";

  if (mail($to, $subject, $body, $headers)) {
    $success = true;
  } else {
    $error = true;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact | BottleSort</title>
  <link rel="icon" type="image/png" href="img/logo8.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Contact-specific styles -->
  <style>
    #contact {
      position: relative;
      min-height: 40vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 7rem 2rem 5rem;
      color: #004e44;
    }

    #contact::before { display: none; }
    #contact > * { position: relative; z-index: 1; }

    .contact-header {
      display: flex;
      gap: 3rem;
      align-items: center;
      justify-content: center;
      max-width: 1200px;
      width: 100%;
      margin-bottom: 3rem;
      text-align: center;
    }

    .contact-intro {
      flex: 1;
      color: #ffffff;
    }

    .contact-intro h1 {
      font-size: 2.6rem;
      margin-bottom: 1rem;
      color: #ffffff;
      text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    .contact-intro p {
      line-height: 1.7;
      font-size: 1.1rem;
      color: #eafaf4;
    }

    .contact-container {
      display: flex;
      gap: 2rem;
      justify-content: center;
      align-items: flex-start;
      max-width: 1200px;
      width: 100%;
    }

    form {
      background: rgba(255, 255, 255, 0.12);
      color: #ffffff;
      border-radius: 12px;
      padding: 2.5rem;
      flex: 1;
      max-width: 650px;
      text-align: left;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.15);
    }

    form label {
      display: block;
      font-weight: 600;
      margin-top: 1rem;
      color: #ffffff;
    }

    form input, form textarea, form select {
      width: 100%;
      padding: 0.9rem;
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 6px;
      margin-top: 0.5rem;
      font-family: 'Open Sans', sans-serif;
      font-size: 1rem;
      transition: border-color 0.3s ease;
      background: rgba(255,255,255,0.1);
      color: #ffffff;
    }

    form input::placeholder,
    form textarea::placeholder {
      color: rgba(255,255,255,0.6);
    }

    form select option {
      background: #004e44;
      color: #ffffff;
    }

    form input:focus, form textarea:focus, form select:focus {
      outline: none;
      border-color: rgba(255,255,255,0.6);
      background: rgba(255,255,255,0.15);
    }

    #other_inquiry_container { display: none; }

    form textarea {
      resize: vertical;
      min-height: 180px;
    }

    form button {
      background: rgba(255,255,255,0.2);
      color: white;
      border: 1px solid rgba(255,255,255,0.3);
      padding: 1rem 2rem;
      border-radius: 6px;
      margin-top: 1.5rem;
      cursor: pointer;
      font-weight: 600;
      font-size: 1rem;
      transition: all 0.3s ease;
      width: 100%;
    }

    form button:hover {
      background: rgba(255,255,255,0.3);
      border-color: rgba(255,255,255,0.5);
    }

    .message {
      margin-top: 1rem;
      padding: 1rem;
      border-radius: 6px;
      font-weight: 600;
      text-align: center;
    }

    .success {
      background: #c5e8d7;
      color: #006b5f;
    }

    .error {
      background: #f8d7da;
      color: #721c24;
    }

    .privacy {
      max-width: 1200px;
      width: 100%;
      text-align: center;
      font-size: 0.9rem;
      line-height: 1.7;
      margin-top: 2rem;
      color: rgba(255,255,255,0.8);
      padding: 0 2rem;
    }

    .privacy h3 {
      margin-bottom: 0.8rem;
      color: #ffffff;
      font-size: 1.2rem;
      font-weight: 600;
    }

    .privacy p {
      color: #ffffff;
    }

    .privacy strong {
      color: #ffffff;
    }

    @media (max-width: 900px) {
      .contact-header {
        flex-direction: column;
        gap: 2rem;
      }

      .contact-intro h1 {
        font-size: 2.2rem;
      }

      .contact-intro p {
        font-size: 1rem;
      }

      .contact-container {
        flex-direction: column;
        align-items: center;
      }

      form {
        max-width: 100%;
      }

      .privacy {
        max-width: 100%;
      }
    }

    @media (max-width: 480px) {
      .contact-intro h1 {
        font-size: 1.9rem;
      }

      form {
        padding: 1.5rem;
      }

      .privacy {
        font-size: 0.85rem;
      }

      .privacy h3 {
        font-size: 1.1rem;
      }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section id="contact">
  <div class="contact-header" data-aos="fade-down">
    <div class="contact-intro">
      <h1>Contact BottleSort</h1>
      <p>We'd love to hear from you! Please select your inquiry type and send us a message. Your feedback helps us improve and innovate our plastic waste management solutions.</p>
    </div>
  </div>

  <div class="contact-container">
    <form method="POST" data-aos="fade-up" data-aos-delay="300">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" placeholder="Your name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="your@email.com" required>

      <label for="inquiry_type">Inquiry Type</label>
      <select id="inquiry_type" name="inquiry_type" required>
        <option value="">-- Select an Option --</option>
        <option value="Partnership or Collaboration">Partnership or Collaboration</option>
        <option value="Technical Support">Technical Support</option>
        <option value="Feedback or Suggestions">Feedback or Suggestions</option>
        <option value="General Question">General Question</option>
        <option value="Other">Other (Please specify below)</option>
      </select>

      <div id="other_inquiry_container">
        <label for="other_inquiry">Please specify</label>
        <input type="text" id="other_inquiry" name="other_inquiry" placeholder="Your inquiry type">
      </div>

      <label for="message">Message</label>
      <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>

      <button type="submit">Send Message</button>

      <?php if (!empty($success)): ?>
        <div class="message success">Message sent successfully! Thank you for contacting us.</div>
      <?php elseif (!empty($error)): ?>
        <div class="message error">Failed to send your message. Please try again later.</div>
      <?php endif; ?>
    </form>
  </div>

  <div class="privacy" data-aos="fade-up" data-aos-delay="500">
    <h3>Privacy Notice</h3>
    <p>
      By submitting this form, you consent to BottleSort collecting and processing your personal data 
      (name, email, and message) solely for the purpose of addressing your inquiry. 
      Your data will not be shared with third parties and will be deleted after your request is resolved.
    </p>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });

  // Show or hide the "Other" text box
  const inquirySelect = document.getElementById('inquiry_type');
  const otherContainer = document.getElementById('other_inquiry_container');

  inquirySelect.addEventListener('change', function() {
    if (this.value === 'Other') {
      otherContainer.style.display = 'block';
    } else {
      otherContainer.style.display = 'none';
      document.getElementById('other_inquiry').value = '';
    }
  });
</script>

</body>
</html>