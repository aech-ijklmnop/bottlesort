<?php
// prototype.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Prototype | BottleSort</title>
  <link rel="icon" type="image/png" href="img/logo8.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Main CSS -->
  <link rel="stylesheet" href="css/style.css">

  <!-- Prototype-specific styles -->
  <style>
    #prototype {
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

    #prototype::before { display: none; }
    #prototype > * { position: relative; z-index: 1; }

    #prototype h1 {
      font-size: 2.6rem;
      margin-bottom: 1rem;
      color: #ffffff;
      text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    #prototype p.section-desc {
      max-width: 850px;
      line-height: 1.7;
      font-size: 1.1rem;
      margin-bottom: 3rem;
      color: #eafaf4;
    }

    .cards-grid {
      display: flex;
      gap: 25px;
      justify-content: center;
      flex-wrap: wrap;
      width: 100%;
      max-width: 1200px;
    }

    .card {
      background: rgba(255,255,255,0.12);
      color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
      width: 380px;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      border: 1px solid rgba(255,255,255,0.15);
      display: flex;
      flex-direction: column;
      min-height: 480px;
    }

    .card:hover {
      transform: translateY(-5px);
      background: rgba(255,255,255,0.22);
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
    }

    .card img {
      width: 100%;
      height: 350px;
      object-fit: contain;
      margin-bottom: 10px;
    }

    .card-content {
      margin-top: auto;
    }

    .card h3 {
      color: #ffffff;
      margin-bottom: 12px;
      font-size: 1.5rem;
    }

    .card p {
      color: #d9fff2;
      font-size: 1.05rem;
      margin: 0;
      line-height: 1.5;
    }

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
      padding: 20px;
    }

    .modal-content {
      background: #ffffff;
      color: #004e44;
      padding: 2rem;
      border-radius: 14px;
      box-shadow: 0 0 30px rgba(0,0,0,0.5);
      width: 90%;
      max-width: 900px;
      max-height: 90vh;
      overflow-y: auto;
      position: relative;
    }

    .modal-content h2 {
      text-align: center;
      margin-bottom: 1rem;
      padding: 0.8rem 0;
      font-size: 1.8rem;
      font-weight: 700;
      color: #006b5f;
      border-bottom: 2px solid #c5e8d7;
    }

    .modal-content > p {
      font-size: 1rem;
      line-height: 1.7;
      margin-bottom: 1.5rem;
    }

    .modal-close {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 2rem;
      color: #006b5f;
      cursor: pointer;
      transition: color 0.2s ease;
      z-index: 2001;
      background: none;
      border: none;
    }

    .modal-close:hover {
      color: #00bfa6;
    }

    /* Component Rows */
    .component-row {
      display: flex;
      align-items: center;
      gap: 2rem;
      margin: 2rem 0;
      padding: 1.5rem;
      background: #f8fffe;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .component-row.reverse {
      flex-direction: row-reverse;
    }

    .component-row img {
      width: 240px;
      height: 240px;
      object-fit: contain;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      flex-shrink: 0;
      background: #ffffff;
      padding: 10px;
    }

    .component-row .text-content {
      flex: 1;
      text-align: left;
    }

    .component-row h4 {
      color: #006b5f;
      margin-bottom: 0.8rem;
      font-size: 1.3rem;
      font-weight: 600;
    }

    .component-row p {
      font-size: 1rem;
      line-height: 1.7;
      color: #004e44;
      margin: 0;
    }

    @media (max-width: 900px) {
      #prototype h1 { font-size: 2.2rem; }
      #prototype p.section-desc { font-size: 1rem; }
      .card { width: 320px; min-height: 440px; }
      .card img { height: 240px; }
      
      .component-row, 
      .component-row.reverse {
        flex-direction: column;
        text-align: center;
      }
      
      .component-row .text-content {
        text-align: center;
      }
      
      .component-row img {
        width: 200px;
        height: 200px;
      }
      
      .modal-content h2 { font-size: 1.5rem; }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<section id="prototype">
  <h1 data-aos="fade-down">BottleSort Sytem Design</h1>
  <p class="section-desc" data-aos="fade" data-aos-delay="300">
    <em>This system integrates hardware, software, and intelligent control systems to perform accurate plastic classification and waste segregation. The following sections highlight the core elements of its design and functionality.</em>
  </p>

  <div class="cards-grid" data-aos="fade-up" data-aos-delay="600">
    <div class="card" id="hardware-card">
      <img src="img/hardware.png" alt="Hardware Design">
      <div class="card-content">
        <h3>Hardware Design</h3>
        <p><em>Physical assembly and integration of sensors, actuators, and the processing unit that enable automation.</em></p>
      </div>
    </div>

    <div class="card" id="classification-card">
      <img src="img/classification.png" alt="Classification Area">
      <div class="card-content">
        <h3>Classification Area</h3>
        <p><em>Core area where intelligent analysis identifies the plastic type using sensor data and machine learning models.</em></p>
      </div>
    </div>

    <div class="card" id="bins-card">
      <img src="img/bins.png" alt="Bin Receptacles">
      <div class="card-content">
        <h3>Bin Receptacles</h3>
        <p><em>Organized collection system with color-coded bins ensuring systematic segregation of plastic types.</em></p>
      </div>
    </div>
  </div>
</section>

<!-- MODALS -->
<div id="hardwareModal" class="modal">
  <div class="modal-content">
    <button class="modal-close" id="closeHardware" aria-label="Close">&times;</button>
    <h2>Hardware Design</h2>

    <p data-aos="fade-up" data-aos-delay="50">
      The hardware design integrates detection sensors, actuation modules, power regulation units and user interface components controlled by a central processor. Below are the physical components used in the prototype and a short explanation of their roles within the BottleSort system.
    </p>

    <div class="component-row" data-aos="fade-right" data-aos-delay="80">
      <img src="img/rpi.png" alt="Raspberry Pi 5">
      <div class="text-content">
        <h4>Raspberry Pi 5</h4>
        <p>
          Serves as the central processing unit managing sensor input, running the classification inference and controlling motors and displays.
        </p>
      </div>
    </div>

    <div class="component-row reverse" data-aos="fade-left" data-aos-delay="120">
      <img src="img/ultrasonic.png" alt="Ultrasonic HC-SR04 sensors">
      <div class="text-content">
        <h4>Ultrasonic Sensors (HC-SR04)</h4>
        <p>
          One ultrasonic sensor per bin measures distance to the bin surface and estimates fill level. The Raspberry Pi polls these sensors; when a bin reaches the configured threshold the system marks it as full and prevents further routing to that receptacle.
        </p>
      </div>
    </div>

    <div class="component-row" data-aos="fade-right" data-aos-delay="160">
      <img src="img/tb6600.png" alt="TB6600 stepper driver">
      <div class="text-content">
        <h4>TB6600 Stepper Motor Driver</h4>
        <p>
          Drives the stepper motor with microstepping capability to achieve smooth rotation and precise positioning of the bin carousel. The TB6600 accepts step/dir signals from the controller (Raspberry Pi via a microcontroller or stepper interface).
        </p>
      </div>
    </div>

    <div class="component-row reverse" data-aos="fade-left" data-aos-delay="200">
      <img src="img/steppermotor.png" alt="Wantai NEMA 17 stepper motor">
      <div class="text-content">
        <h4>Wantai Stepper Motor — NEMA 17</h4>
        <p>
          Rotates the bin platform. The control logic divides the full rotation into five equal positions (one per bin). Using the TB6600 driver, the system performs precise indexing so the correct bin aligns under the chute for each classified item.
        </p>
      </div>
    </div>

    <div class="component-row" data-aos="fade-right" data-aos-delay="240">
      <img src="img/servo.png" alt="MG996R Servo Motor">
      <div class="text-content">
        <h4>Tower Pro MG996R Servo Motor</h4>
        <p>
          Operates the chute door (open/close) to release a single bottle into the selected bin. The servo's timing is coordinated with the stepper's position to ensure reliable drops without collisions.
        </p>
      </div>
    </div>

    <div class="component-row reverse" data-aos="fade-left" data-aos-delay="280">
      <img src="img/lcd.png" alt="16x2 I2C LCD">
      <div class="text-content">
        <h4>16×2 I2C LCD Display</h4>
        <p>
          Displays real-time information such as detected plastic type, bin fill percentages, and system messages — useful for on-site monitoring and debugging during testing phases.
        </p>
      </div>
    </div>

    <div class="component-row" data-aos="fade-right" data-aos-delay="320">
      <img src="img/microwave.png" alt="HFS-DC06 Microwave Radar Sensor">
      <div class="text-content">
        <h4>HFS-DC06 Microwave Radar Sensor</h4>
        <p>
          Detects motion/presence when a bottle is thrown into the chute, serving as the trigger to start image/sensor acquisition and the classification workflow. Works reliably in varying light conditions.
        </p>
      </div>
    </div>

    <div class="component-row reverse" data-aos="fade-left" data-aos-delay="360">
      <img src="img/hall.png" alt="KY-003 Hall magnetic sensor">
      <div class="text-content">
        <h4>KY-003 Hall Magnetic Sensor Module</h4>
        <p>
          Detects a small magnet attached to the PET bin to establish a "home" or reference position. This allows the controller to recalibrate the carousel and recover from step drift or missed steps.
        </p>
      </div>
    </div>

    <div class="component-row" data-aos="fade-right" data-aos-delay="400">
      <img src="img/buck.png" alt="HW-688 / XY-3606 buck converter">
      <div class="text-content">
        <h4>XY-3606 DC-DC Buck Converters</h4>
        <p>
          Two buck converters step 12V down to stable 5V rails. One converter powers the 5 ultrasonic sensors; the other powers the microwave sensor, Hall sensor, and servo motor — separating loads improves reliability and reduces electrical noise.
        </p>
      </div>
    </div>

    <div class="component-row reverse" data-aos="fade-left" data-aos-delay="440">
      <img src="img/powersupply.png" alt="12V 5A Power Adapter">
      <div class="text-content">
        <h4>12V 5A Adapter</h4>
        <p>
          Provides the primary power source for the stepper driver and buck converters. A true-rated supply ensures sufficient overhead for motor surges and stable operation of the entire system.
        </p>
      </div>
    </div>
  </div>
</div>

<div id="classificationModal" class="modal">
  <div class="modal-content">
    <button class="modal-close" id="closeClassification" aria-label="Close">&times;</button>
    <h2>Classification Area</h2>

    <p data-aos="fade-up" data-aos-delay="60">
      The classification area combines sensor inputs and a trained machine learning model to identify the plastic type (PET, HDPE, LDPE, PP, Unclassified). The system uses an AI model trained with a comprehensive dataset at Edge Impulse, deployed on the Raspberry Pi for real-time inference.
    </p>

    <div class="component-row" data-aos="fade-right" data-aos-delay="100">
      <img src="img/sensor.jpg" alt="Sensor array">
      <div class="text-content">
        <h4>Sensor Array & Object Detection</h4>
        <p>
          The combined data sources including camera imagery and object detection from the microwave radar sensor provide robust features that help the model distinguish plastic bottles from other plastics even when visual cues are ambiguous. The microwave sensor ensures reliable detection regardless of lighting conditions.
        </p>
      </div>
    </div>

    <div class="component-row reverse" data-aos="fade-left" data-aos-delay="140">
      <img src="img/ml.jpg" alt="Machine learning">
      <div class="text-content">
        <h4>Machine Learning Algorithm & Training</h4>
        <p>
          The AI model was trained using Edge Impulse's machine learning platform with a comprehensive dataset of plastic bottle images representing different plastic types. The model uses a convolutional neural network (CNN) architecture optimized for edge devices. The dataset was split following an 80/20 ratio, where 80% of the images were used for training the model and 20% were reserved for testing. This ratio ensures that the model learns effectively from the majority of the data while maintaining a separate portion to evaluate its accuracy and generalization. Once trained, it was converted to TensorFlow Lite format and deployed on the Raspberry Pi for real-time classification. When the model produces a classification result, the control logic triggers the stepper/servo routine to route the bottle to the correct bin.
      </div>
    </div>
  </div>
</div>

<div id="binsModal" class="modal">
  <div class="modal-content">
    <button class="modal-close" id="closeBins" aria-label="Close">&times;</button>
    <h2>Bin Receptacles</h2>

    <p data-aos="fade-up" data-aos-delay="60">
      Bin receptacles are color-coded following the Resin Identification Code (RIC) standard to provide visual consistency with international plastic sorting conventions. Each bin is instrumented with an ultrasonic sensor for bin-level monitoring. The system routes bottles to: PET, HDPE, LDPE, PP, and Unclassified bins; bins reaching capacity are flagged on the LCD and analytics dashboard.
    </p>

    <div class="component-row" data-aos="fade-up" data-aos-delay="80" style="justify-content: center;">
      <img src="img/colorcodeRIC.png" alt="Resin Identification Code color coding reference" style="width: 100%; max-width: 600px; height: auto;">
    </div>

    <p data-aos="fade-up" data-aos-delay="90" style="text-align: center; font-style: italic; color: #006b5f; margin-bottom: 2rem;">
      Color coding follows the standardized Resin Identification Code (RIC) system for plastic classification.
    </p>
  </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });

  const modalMap = [
    { card: 'hardware-card', modal: 'hardwareModal', close: 'closeHardware' },
    { card: 'classification-card', modal: 'classificationModal', close: 'closeClassification' },
    { card: 'bins-card', modal: 'binsModal', close: 'closeBins' }
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