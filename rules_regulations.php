<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="description" content="Smart Hostel Management System" />
    <meta name="Author" content="Alex Kihara" />
    <link rel="stylesheet" href="CASCADINGSTYLES/rules.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="JAVASCRIPT_SHMS/rules_regulations_student.js" defer></script>
    <link rel="icon" href="Img/favicon.jpg" />  
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Rules & Regulations | Smart Hostel Management System</title>
  </head>
  <body>
    <header>
  <nav>
    <div class="logo">
      <img src="Img/favicon.jpg" alt="SHMS Logo">
    </div>

    <ul class="nav-links">
      <li><a href="home_student.php">Home</a></li>
      <li><a href="dashboard_student.php">Dashboard</a></li>
      <li><a href="book_room.php">Rooms</a></li>
      <li><a href="view_room_status_student.php">View room status</a></li>
      <li><a href="submit_complaint_student.php">Submit Complaint</a></li>
      <li><a href="payment_status_student.php">Payment Status</a></li>
      <li class="dropdown">
        <a href="#">More <i class="fa-solid fa-caret-down"></i></a>
        <div class="dropdown-content">
          <a href="help_FAQs.php" style="background-color:#fff;color:black;">FAQ</a>
          <a href="rules_regulations.php" style="background-color:#fff;color:black;">Rules & Regulations</a>
          <a href="profile.php" style="background-color:#fff;color:black;">Profile</a>
          <a href="logout.php" style="background-color:#fff;color:black;">Log out</a>
        </div>
      </li>
    </ul>

    <div class="icons">
      <div class="hamburger" id="hamburger">
        <span></span><span></span><span></span>
      </div>
      <i class="fa-regular fa-bell"></i>
    </div>
  </nav>
</header>

<!-- =========== MOBILE MENU =========== -->
<div class="mobile-menu" id="mobileMenu">
  <ul>
    <li><a href="home_student.php">Home</a></li>
    <li><a href="dashboard_student.php">Dashboard</a></li>
    <li><a href="book_room.php">Rooms</a></li>
    <li><a href="view_room_status_student.php">View room status</a></li>
    <li><a href="submit_complaint_student.php">Submit Complaint</a></li>
    <li><a href="payment_status_student.php">Payment Status</a></li>
    <li><a href="help_FAQs.php">FAQs</a></li>
    <li><a href="rules_regulations.php">Rules & Regulations</a></li>
    <li><a href="profile_student.php">Profile</a></li>
    <li><a href="logout.php">Log out</a></li>
  </ul>
</div>
<style>
    .whatsapp-float {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 100;
    background-color: #25D366; /* WhatsApp green */
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    transition: transform 0.2s;
    font-size: 28px;
}

.whatsapp-float:hover {
    transform: scale(1.1);
    background-color: #128C7E; /* darker green on hover */
}

</style>

    <br>
    <!-- WhatsApp Floating Button using Font Awesome -->
    <!-- WhatsApp Floating Button using Font Awesome -->
    <a href="https://wa.me/254737074160" target="_blank" class="whatsapp-float" title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
    <main class="shms-main">
  <h1 class="shms-title">Smart Hostel Management System</h1>
  <h2 class="shms-subtitle">Hostel Rules &amp; Regulations</h2>
  <p class="shms-intro">
    Please read these rules carefully. They are intended to ensure safety,
    fairness, and a peaceful living environment for all residents.
  </p>

  <!-- General Conduct -->
  <section class="shms-section shms-general">
    <h3 class="shms-section-title">General Conduct</h3>
    <p class="shms-section-text">
      All residents must behave responsibly and respectfully while on hostel
      premises. The following expectations apply at all times:
    </p>
    <ul class="shms-list">
      <li>Observe quiet hours (10:00 PM – 6:00 AM) — minimize noise, no loud music or parties.</li>
      <li>Keep shared spaces tidy (kitchen, bathrooms, lounges).</li>
      <li>No theft, vandalism, or tampering with hostel property or others’ belongings.</li>
      <li>Guests must be approved and cannot stay overnight without permission.</li>
      <li>Follow fire, health and safety regulations — no unauthorized electrical appliances.</li>
      <li>Smoking, vaping, and illegal drugs are strictly prohibited.</li>
      <li>Dress appropriately and follow the institution’s dress code.</li>
    </ul>
  </section>

  <!-- Payments and Booking -->
  <section class="shms-section shms-payments">
    <h3 class="shms-section-title">Payments, Booking &amp; Registration</h3>
    <p class="shms-section-text">
      Residents must ensure the following to remain in good standing:
    </p>
    <ul class="shms-list">
      <li>Keep booking and payment records up to date. Late payments may attract penalties.</li>
      <li>All fees must be paid using approved channels; keep receipts.</li>
      <li>Do not transfer or sell your room without approval.</li>
      <li>Report changes in contact details, allergies, or medical issues immediately.</li>
    </ul>
  </section>

  <!-- Safety and Security -->
  <section class="shms-section shms-safety">
    <h3 class="shms-section-title">Safety &amp; Security</h3>
    <p class="shms-section-text">Observe the following:</p>
    <ul class="shms-list">
      <li>Always lock your room and report security breaches immediately.</li>
      <li>Do not prop open external doors. Use access cards/keys.</li>
      <li>Report suspicious persons or lost property.</li>
      <li>Cooperate with staff during inspections or emergency drills.</li>
    </ul>
  </section>

  <!-- Complaints and Repairs -->
  <section class="shms-section shms-complaints">
    <h3 class="shms-section-title">Complaints, Repairs &amp; Maintenance</h3>
    <p class="shms-section-text">
      Use the official complaint system to report faults or request maintenance:
    </p>
    <ol class="shms-list">
      <li>Submit via SHMS “Complaints” module with details and optional evidence.</li>
      <li>Admin reviews and assigns for repair or response.</li>
      <li>Students are notified via SHMS notifications.</li>
    </ol>
    <p class="shms-section-text">
      Do not attempt repairs yourself unless authorized.
    </p>
  </section>

  <!-- Prohibited Items & Behavior -->
  <section class="shms-section shms-prohibited">
    <h3 class="shms-section-title">Prohibited Items &amp; Behaviour</h3>
    <ul class="shms-list">
      <li>Weapons, explosives, or hazardous materials.</li>
      <li>Unauthorized commercial activity without approval.</li>
      <li>Behavior endangering health or safety of others.</li>
      <li>Using another resident’s access card, keys, or impersonation.</li>
    </ul>
  </section>

  <!-- Offences and Penalties -->
  <section class="shms-section shms-penalties">
    <h3 class="shms-section-title">Offences and Penalties</h3>
    <p class="shms-section-text">
      The table below lists common offences and penalties.
    </p>

    <div class="shms-table-responsive">
      <table class="shms-table">
        <thead>
          <tr>
            <th>S/No</th>
            <th>Offence</th>
            <th>Typical Penalty</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Minor disturbance / noise after quiet hours</td>
            <td>Verbal warning; repeated offences: formal warning & fine.</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Packing or possessing unauthorized materials (e.g., prohibited appliances)</td>
            <td>Confiscation; formal warning; repeated offences may lead to suspension.</td>
          </tr>
          <tr>
            <td>3</td>
            <td>Non-payment or delayed payment of hostel fees</td>
            <td>Late fee; temporary suspension; continued non-payment may lead to cancellation.</td>
          </tr>
          <tr>
            <td>4</td>
            <td>Damage or vandalism to hostel property</td>
            <td>Full restitution plus disciplinary action.</td>
          </tr>
          <tr>
            <td>5</td>
            <td>Unauthorized guest staying overnight</td>
            <td>Warning and guest removal; repeat offences: fines & suspension.</td>
          </tr>
          <tr>
            <td>6</td>
            <td>Use of alcohol, drugs or violent behavior</td>
            <td>Immediate eviction; suspension or expulsion depending on severity.</td>
          </tr>
          <tr>
            <td>7</td>
            <td>Impersonation or forging documents</td>
            <td>Cancellation of booking; suspension; possible legal action.</td>
          </tr>
          <tr>
            <td>8</td>
            <td>Refusal to cooperate with staff or security</td>
            <td>Formal warning; if persistent, suspension and counselling.</td>
          </tr>
          <tr>
            <td>9</td>
            <td>Concealing identity during checks</td>
            <td>Warning; repeated offences: suspension.</td>
          </tr>
          <tr>
            <td>10</td>
            <td>Serious violence or causing bodily harm</td>
            <td>Immediate eviction and expulsion; possible legal prosecution.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <p class="shms-section-text">
      <strong>Note:</strong> This table is illustrative. Final sanctions follow institutional procedures.
    </p>
  </section>

  <hr class="shms-hr" />

  <!-- Reporting & Appeals -->
  <section class="shms-section shms-reporting">
    <h3 class="shms-section-title">Reporting &amp; Appeals</h3>
    <p class="shms-section-text">
      Appeals must be submitted in writing within 7 days, providing supporting evidence. All appeals are reviewed according to policy.
    </p>
  </section>

  <!-- Acknowledgement -->
  <section class="shms-section shms-acknowledge">
    <h3 class="shms-section-title">Acknowledgement</h3>
    <p class="shms-section-text">
      By staying in the hostel, you acknowledge that you have read, understood, and agreed to comply with these rules and regulations.
    </p>
  </section>
</main>
<footer class="shms-footer">
    <!-- Container for the four main columns -->
    <div class="shms-footer-columns">
        <!-- Column 1: About -->
        <div class="shms-footer-about">
            <h3>About SHMS</h3>
            <p>SHMS modernizes university hostel operations by providing students with seamless online booking, payment, and communication services, aiming to create a more efficient living and learning environment.</p>
        </div>

        <!-- Column 2: Quick Links -->
        <nav class="shms-footer-quicklinks" aria-label="Quick Navigation Links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="dashboard_student.php">Dashboard</a></li>
                <li><a href="book_room.php">Rooms</a></li>
                <li><a href="rules_regulations.php">Rules & Regulations</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="submit_complaint_student.php">Submit Complaint</a></li>
            </ul>
        </nav>

        <!-- Column 3: Popular Services -->
        <div class="shms-footer-services">
            <h3>Popular Services</h3>
            <ul>
                <li>Wifi</li>
                <li>Laundry</li>
                <li>Meals/Cafeteria</li>
                <li>Housekeeping</li>
            </ul>
        </div>

        <!-- Column 4: Socials -->
        <nav class="shms-footer-socials" aria-label="SHMS Social Media">
            <h3>Socials</h3>
            <ul>
                <li><a href="https://www.facebook.com/profile.php?id=61583166006604" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://www.instagram.com/smarthostelmanagementsystem/" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="https://www.tiktok.com/@smart.hostel.mana?_r=1&_t=ZM-91btgFDD16u" target="_blank"><i class="fab fa-tiktok"></i> TikTok</a></li>
            </ul>
        </nav>
    </div>

    <!-- Legal Links -->
    <div class="shms-footer-legal">
        <nav>
            <a href="privacy.php">Privacy Policy</a>
            <a href="terms.php">Terms & Conditions</a>
            <a href="about.php">About</a>
        </nav>
    </div>

    <!-- Copyright -->
    <div class="shms-footer-copy">
        <p>© 2025 Smart Hostel Management System. All rights reserved.</p>
    </div>
</footer>
          
        </body>
      </html>
    </main>
  </body>
</html>
