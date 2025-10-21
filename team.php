<?php
// team.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Team | BottleSort</title>
  <link rel="icon" type="image/png" href="img/logo8.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Team-specific styles -->
  <style>
    #team {
      position: relative;
      min-height: 40vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 7rem 2rem 5rem;
      color: #004e44;
    }

    #team::before { display: none; }
    #team > * { position: relative; z-index: 1; }

    #team h1 {
      font-size: 2.6rem;
      margin-bottom: 1rem;
      color: #ffffff;
      text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    #team p.section-desc {
      max-width: 850px;
      line-height: 1.7;
      font-size: 1.1rem;
      margin-bottom: 3rem;
      color: #eafaf4;
    }

    .team-grid {
      display: flex;
      gap: 25px;
      justify-content: center;
      flex-wrap: wrap;
      width: 100%;
      max-width: 1200px;
    }

    .team-card {
      background: rgba(255,255,255,0.12);
      color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
      width: 280px;
      cursor: default;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.15);
      display: flex;
      flex-direction: column;
    }

    .profile-img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .team-card h3 {
      color: #ffffff;
      margin-bottom: 8px;
      font-size: 1.3rem;
    }

    .team-card p {
      color: #d9fff2;
      font-size: 0.95rem;
      margin: 0;
      line-height: 1.5;
    }

    @media (max-width: 900px) {
      #team h1 { font-size: 2.2rem; }
      #team p.section-desc { font-size: 1rem; }
      .team-card { width: 260px; }
      .profile-img { height: 200px; }
      .modal-content h2 { font-size: 1.5rem; }
    }

    @media (max-width: 480px) {
      #team h1 { font-size: 1.9rem; }
      .team-card { width: 100%; max-width: 300px; }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section id="team">
  <h1 data-aos="fade-down">Behind BottleSort: Our Team</h1>
  <p class="section-desc" data-aos="fade" data-aos-delay="300">
    <em>Meet the team dedicated to transforming plastic waste management through technology.</em>
  </p>

  <div class="team-grid" data-aos="fade-up" data-aos-delay="600">
    <!-- Cherny -->
    <div class="team-card" id="cherny-card">
      <img src="img/cherny.png" alt="Cherny" class="profile-img">
      <h3>Cherny Gain Simbajon</h3>
      <p>BS Computer Engineering - 4th Year<br>
      <br>La Salle University - Ozamiz</p>

    </div>

    <!-- Hannah -->
    <div class="team-card" id="hannah-card">
      <img src="img/hannah.png" alt="Hannah" class="profile-img">
      <h3>Hannah Joy Almendras</h3>
      <p>BS Computer Engineering - 4th Year<br>
      <br>La Salle University - Ozamiz</p>
    </div>

    <!-- Jasper -->
    <div class="team-card" id="jasper-card">
      <img src="img/jasper.png" alt="Jasper" class="profile-img">
      <h3>Jasper John</h3>
      <h3>Paitan</h3>
      <p>BS Computer Engineering - 4th Year<br>
      <br>La Salle University - Ozamiz</p>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });
</script>
</body>
</html>