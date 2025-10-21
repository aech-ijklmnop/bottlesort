<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About | BottleSort</title>
  <link rel="icon" type="image/png" href="img/logo8.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- About-specific styles -->
  <style>
    #about {
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

    #about::before { display: none; }   
    #about > * { position: relative; z-index: 1; }

    #about h1 { 
      font-size: 2.6rem; 
      margin-bottom: 1rem; 
      color: #ffffff; 
      text-shadow: 0 2px 10px rgba(0,0,0,0.3); 
    }

    #about p { 
      max-width: 850px; 
      line-height: 1.7; 
      font-size: 1.1rem; 
      margin-bottom: 2rem; 
      color: #eafaf4; 
    }

    .types { display: flex; gap: 25px; justify-content: center; flex-wrap: wrap; width: 100%; max-width: 1200px; }

    .type-card {
      background: rgba(255,255,255,0.12);
      color: #ffffff;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
      width: 220px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.15);
    }

    .type-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.22); box-shadow: 0 6px 20px rgba(0,0,0,0.3); }

    .type-card img { width: 90px; height: 90px; margin-bottom: 10px; object-fit: contain; }
    .type-card h3 { color: #ffffff; margin-bottom: 8px; }
    .type-card p { color: #d9fff2; font-size: 0.95rem; margin: 0; }

    /* ---------------------- MODALS ---------------------- */
    .modal {
      display: none;
      position: fixed;
      z-index: 2000;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.75);
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #ffffff;
      color: #004e44;
      text-align: center;
      padding: 25px;
      border-radius: 14px;
      box-shadow: 0 0 30px rgba(0,0,0,0.5);
      width: 90%;
      max-width: 400px;
      position: relative;
    }

    .modal-content h2 { margin-bottom: 15px; }
    .modal-content img { width: 100%; border-radius: 10px; margin-top: 10px; }

    .modal-close {
      position: absolute;
      top: 20px;
      right: 25px;
      font-size: 2.5rem;
      color: white;
      cursor: pointer;
      transition: color 0.2s ease;
      z-index: 2001;
    }

    .modal-close:hover { color: #00bfa6; }

    @media (max-width: 900px) {
      #about h1 { font-size: 2.2rem; }
      #about p { font-size: 1rem; }
      .type-card { width: 180px; }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- MAIN CONTENT WRAPPER -->
<main>
  <section id="about">
    <h1 data-aos="fade-down">Automatic Plastic Bottle Segregation</h1>
    <p data-aos="fade" data-aos-delay="300">
      <em>BottleSort is designed to transform how waste is managed at the source. Using a combination of sensors and automated processes, the system efficiently identifies and sorts plastic bottles into five categories — PP, PET, HDPE, LDPE, and Unclassified. By combining smart engineering with sustainability goals, BottleSort speeds up recycling, reduces contamination, and promotes responsible waste disposal.</em>
    </p>

    <div class="types" data-aos="fade-up" data-aos-delay="600">
      
      <div class="type-card" id="pet-card">
        <img src="img/pet.png" alt="PET Bottles">
        <h3>PET (Polyethylene Terephthalate)</h3>
        <p><em>Transparent bottles often used for water and soft drinks.</em></p>
      </div>

      <div class="type-card" id="hdpe-card">
        <img src="img/hdpe.png" alt="HDPE Bottles">
        <h3>HDPE (High-Density Polyethylene)</h3>
        <p><em>Opaque and sturdy bottles used in milk jugs and detergents.</em></p>
      </div>

      <div class="type-card" id="ldpe-card">
        <img src="img/ldpe.png" alt="LDPE Bottles">
        <h3>LDPE (Low-Density Polyethylene)</h3>
        <p><em>Flexible plastic bottles used in squeezable products.</em></p>
      </div>

      <div class="type-card" id="pp-card">
        <img src="img/pp.png" alt="PP Bottles">
        <h3>PP (Polypropylene)</h3>
        <p><em>Lightweight and durable bottles used in food containers.</em></p>
      </div>

      <div class="type-card" id="others-card">
        <img src="img/other.png" alt="Unclassified Bottles">
        <h3>Unclassified</h3>
        <p><em>Bottles or waste that do not fit the four main categories.</em></p>
      </div>
    </div>
  </section>
</main>

<!-- MODALS -->
<div id="petModal" class="modal">
  <div class="modal-content" data-aos="zoom-in">
    <h2>Visual Representation of PET Bottles</h2>
    <img src="img/pet-about.png" alt="PET Bottle Example">
  </div>
  <span class="modal-close" id="closePet">&times;</span>
</div>

<div id="hdpeModal" class="modal">
  <div class="modal-content" data-aos="zoom-in">
    <h2>Visual Representation of HDPE Bottles</h2>
    <img src="img/hdpe-about.png" alt="HDPE Bottle Example">
  </div>
  <span class="modal-close" id="closeHdpe">&times;</span>
</div>

<div id="ldpeModal" class="modal">
  <div class="modal-content" data-aos="zoom-in">
    <h2>Visual Representation of LDPE Bottles</h2>
    <img src="img/ldpe-about.png" alt="LDPE Bottle Example">
  </div>
  <span class="modal-close" id="closeLdpe">&times;</span>
</div>

<div id="ppModal" class="modal">
  <div class="modal-content" data-aos="zoom-in">
    <h2>Visual Representation of PP Bottles</h2>
    <img src="img/pp-about.png" alt="PP Bottle Example">
  </div>
  <span class="modal-close" id="closePp">&times;</span>
</div>

<div id="othersModal" class="modal">
  <div class="modal-content" data-aos="zoom-in">
    <h2>Visual Representation of Unclassified Waste</h2>
    <img src="img/others-about.png" alt="Other Bottle Example">
  </div>
  <span class="modal-close" id="closeOthers">&times;</span>
</div>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });

  const modalMap = [
    { card: 'pet-card', modal: 'petModal', close: 'closePet' },
    { card: 'hdpe-card', modal: 'hdpeModal', close: 'closeHdpe' },
    { card: 'ldpe-card', modal: 'ldpeModal', close: 'closeLdpe' },
    { card: 'pp-card', modal: 'ppModal', close: 'closePp' },
    { card: 'others-card', modal: 'othersModal', close: 'closeOthers' },
  ];

  modalMap.forEach(({card, modal, close}) => {
    const cardEl = document.getElementById(card);
    const modalEl = document.getElementById(modal);
    const closeEl = document.getElementById(close);

    cardEl.addEventListener('click', () => modalEl.style.display = 'flex');
    closeEl.addEventListener('click', () => modalEl.style.display = 'none');
    window.addEventListener('click', e => { if (e.target === modalEl) modalEl.style.display = 'none'; });
  });
</script>

</body>
</html>