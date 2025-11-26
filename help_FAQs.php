<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <link rel="stylesheet" href="CASCADINGSTYLES/faqs.css" />
    <link rel="icon" href="Img/favicon.jpg" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"  />
      <script src="JAVASCRIPT_SHMS/FAQs_student.js" defer></script>
    <title>FAQs | Smart Hostel Management System</title>
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
      
      <!-- Updated Dropdown -->
      <li class="dropdown">
        <button type="button" class="dropdown-toggle">
          More <i class="fa-solid fa-caret-down"></i>
        </button>
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


<main>
        <h1>Hostel Frequently Asked Questions (FAQ)</h1>
        <p>
            This section provides answers to the most common inquiries regarding living at the hostel, covering everything from payments and facilities to safety procedures and conduct rules.
        </p>

    <main>
        
        <section>
            <h2>Check-in/Check-out</h2>
            <dl>
                <dt>What are the hostel check-in and check-out times?</dt>
                <dd>Check-in is permitted from <strong>2:00 PM</strong> to <strong>10:00 PM</strong>. Check-out is strictly required by <strong>11:00 AM</strong> on the departure date to prepare the room for the next resident.</dd>

                <dt>How do I terminate my stay early? Any refund/penalty policy?</dt>
                <dd>You must provide at least <strong>30 days written notice</strong> to the Hostel Administration. Early termination results in forfeiture of the security deposit and may incur additional contract penalties.</dd>
            </dl>
        </section>

        <section>
            <h2>Payments & Fees</h2>
            <dl>
                <dt>How and when do I pay rent / fees?</dt>
                <dd>Rent is due on the <strong>1st day of every month</strong>. Payment should be made electronically via the secure resident payment portal, details of which were provided upon registration.</dd>

                <dt>What is the late payment policy?</dt>
                <dd>A late fee of 5% of the total rent is automatically applied after the 5th day of the month. Failure to pay by the 10th day may lead to a formal eviction notice being issued.</dd>

                <dt>How much is the security deposit?</dt>
                <dd>The security deposit is equivalent to one month's rent. It is refundable upon check-out, provided the room is clean and there is no damage to hostel property.</dd>
            </dl>
        </section>

        <section>
            <h2>Visitors & Guests</h2>
            <dl>
                <dt>What is the visitor/guest policy and visiting hours?</dt>
                <dd>Visitors are only permitted in the designated ground floor common lounge. Visiting hours are strictly enforced between <strong>10:00 AM and 6:00 PM</strong>, and all visitors must present ID and sign in.</dd>

                <dt>Are overnight guests allowed? Any fees?</dt>
                <dd><strong>No overnight guests are permitted</strong> under any circumstance. This policy ensures the safety and security of all registered residents and complies with fire safety regulations.</dd>

                <dt>Do children count as visitors?</dt>
                <dd>Yes, all non-residents, including minors, are considered visitors and must adhere to the standard visiting hours and common area restrictions.</dd>
            </dl>
        </section>

        <section>
            <h2>Rules & Conduct</h2>
            <dl>
                <dt>Is there a curfew? What happens if I return late?</dt>
                <dd>Yes, the hostel curfew is <strong>11:00 PM</strong>. Residents returning after this time must sign the late-entry log and may face a warning or fine for repeated lateness.</dd>

                <dt>What items are prohibited in the hostel?</dt>
                <dd>Prohibited items include illegal drugs, alcohol, weapons, explosives, portable cooking appliances, candles, and any open flame devices. Violations will result in immediate disciplinary action.</dd>

                <dt>Is smoking allowed? Where?</dt>
                <dd>Smoking (including vaping) is <strong>strictly prohibited inside the building</strong>, including all rooms and bathrooms. There is a single designated smoking area outside near the back gate.</dd>

                <dt>Are pets permitted?</dt>
                <dd>No pets of any kind are permitted. The only exception is for certified service animals, provided the resident submits all required documentation in advance.</dd>

                <dt>How are disputes between residents handled?</dt>
                <dd>Residents should first try to resolve issues amicably. If unresolved, the dispute must be reported to the Warden or the Assistant Manager for formal mediation.</dd>

                <dt>What is the lost & found procedure?</dt>
                <dd>All found items should be handed over to the front desk immediately. Residents can inquire about lost items at the desk during office hours (9:00 AM – 5:00 PM).</dd>
            </dl>
        </section>

        <section>
            <h2>Rooms & Facilities</h2>
            <dl>
                <dt>How do laundry facilities work?</dt>
                <dd>The laundry room is open daily from <strong>7:00 AM to 10:00 PM</strong>. The washing and drying machines are coin-operated; costs are posted on the laundry room door. Please do not leave unattended laundry.</dd>

                <dt>Do you provide bed linen / towels?</dt>
                <dd>Fresh bed linen (sheets and pillowcases) is provided and exchanged weekly at no additional charge. **Towels are not provided** and must be supplied by the resident.</dd>

                <dt>Is there Wi-Fi? Any limits or password policy?</dt>
                <dd>Free high-speed Wi-Fi is available throughout the building. The password is confidential and is only for resident use; sharing it with visitors is prohibited.</dd>

                <dt>Can I decorate my room? Any restrictions?</dt>
                <dd>You may decorate your room using temporary, non-damaging materials like poster putty or tape. You cannot use nails, screws, permanent adhesive, or paint the walls.</dd>

                <dt>How do I request a room change?</dt>
                <dd>Room changes are subject to availability and administrative approval. You must submit a formal request to the Hostel Manager, and an administrative fee may apply.</dd>
            </dl>
        </section>

        <section>
            <h2>Maintenance & Safety</h2>
            <dl>
                <dt>What is the procedure for reporting maintenance/repairs?</dt>
                <dd>Report all non-urgent issues (e.g., slow drain, faulty light) using the online maintenance request form. For urgent matters (e.g., burst pipe), notify the front desk staff immediately.</dd>

                <dt>Who do I contact in an emergency?</dt>
                <dd>In a life-threatening emergency, first call the local emergency service. Then, notify the **Warden** at **+XXX-XXX-1234** or the **Security Desk** at **+XXX-XXX-5678**.</dd>

                <dt>What are the fire safety procedures and assembly point?</dt>
                <dd>The evacuation route is posted on the back of your room door. In case of fire, evacuate immediately to the designated **Assembly Point** in the main courtyard outside the building.</dd>

                <dt>Is there secure storage for valuables?</dt>
                <dd>Each resident is provided with a lockable drawer or cabinet in their room. Residents are responsible for securing their personal valuables; the hostel is not liable for theft.</dd>
            </dl>
        </section>

    </main>
    <script>
      // FAQ collapsible
document.querySelectorAll("dl dt").forEach(dt => {
    dt.addEventListener("click", () => {
        dt.classList.toggle("active");
        const dd = dt.nextElementSibling;
        if (dd.style.display === "block") {
            dd.style.display = "none";
        } else {
            dd.style.display = "block";
        }
    });
});

    </script>
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
