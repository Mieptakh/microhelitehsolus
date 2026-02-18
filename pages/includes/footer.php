<footer class="site-footer">
  <div class="container footer-container">
    <!-- Logo & About -->
    <div class="footer-col footer-about">
      <a href="/" class="footer-logo">
        <img src="/logo\20250320_190104[1].png" alt="Logo MHTeams" />
      </a>
      <p>PT MicroHelix Tech Solutions - Solusi digital terpercaya untuk kebutuhan website dan teknologi Anda.</p>
      <div class="footer-socials">
        <a href="https://instagram.com/microhelitechsolus" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://linkedin.com/company/mhteams" target="_blank" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>

    <!-- Navigation -->
    <div class="footer-col footer-nav">
      <h4>Navigasi</h4>
      <ul>
        <li><a href="/">Beranda</a></li>
        <li><a href="/paket-kami">Paket Kami</a></li>
        <li><a href="/proyek-kami">Proyek Kami</a></li>
        <li><a href="/tentang-kami">Tentang Kami</a></li>
        <li><a href="/kontak">Kontak</a></li>
      </ul>
    </div>

    <!-- Contact Info -->
    <div class="footer-col footer-contact">
      <h4>Kontak Kami</h4>
      <p><i class="fas fa-map-marker-alt"></i> Ngampelsari, Candi Sidoarjo, Indonesia</p>
      <p>
        <i class="fas fa-phone"></i> 
        <a href="https://wa.me/6285183241229" target="_blank" rel="noopener" aria-label="Hubungi via WhatsApp">
          +62 851 8324 1229
        </a>
      </p>
      <p>
        <i class="fas fa-envelope"></i> 
        <a id="email-link" href="#" aria-label="Kirim email ke kami">[email protected]</a>
      </p>

    </div>

    <!-- Google Map -->
    <div class="footer-col footer-map">
      <h4>Lokasi Kami</h4>
<iframe
  width="100%"
  height="150"
  style="border:0"
  loading="lazy"
  allowfullscreen
  referrerpolicy="no-referrer-when-downgrade"
  src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d206.35130866919107!2d112.7194841!3d-7.4912254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sid!2sid">
</iframe>

    </div>
  </div>

<div class="footer-bottom">
  <p>&copy; 2025 - <span id="currentYear"></span> PT MicroHelix Tech Solutions. Semua hak dilindungi.</p>
</div>

<script>
  const startYear = 2025;
  const currentYear = new Date().getFullYear();

  document.getElementById("currentYear").textContent =
    currentYear > startYear ? currentYear : startYear;
</script>



  <a href="#" class="back-to-top" aria-label="Kembali ke atas">
  <i class="fas fa-chevron-up"></i>
</a>

</footer>

<script>
  // Tombol "Back to Top"
  const backToTopButton = document.querySelector('.back-to-top');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      backToTopButton.classList.add('show');
    } else {
      backToTopButton.classList.remove('show');
    }
  });

  backToTopButton.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>

      <script>
        // Email protection
        const user = "contactmhteams";
        const domain = "gmail.com";
        const email = `${user}@${domain}`;
        const link = document.getElementById("email-link");
        link.href = `mailto:${email}`;
        link.textContent = email;
      </script>


<!-- Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" defer></script>
<script src="/assets/js/script.js" defer></script>
<style>

/* // FOOTER SECTION STYLING */
/* 🌌 Global Footer Base */
.site-footer {
  background: linear-gradient(135deg, #1E1E1E 0%, #9C27B0 100%);
  color: #f2f2f2;
  padding: 60px 20px 20px;
  font-family: 'Poppins', sans-serif;
  position: relative;
  z-index: 10;
}

.footer-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

/* 🌟 Footer Columns */
.footer-col h4 {
  font-size: 1.25rem;
  margin-bottom: 1rem;
  color: #ffffff;
  position: relative;
}

.footer-col h4::after {
  content: '';
  display: block;
  width: 40px;
  height: 3px;
  background: #ffffff;
  margin-top: 8px;
  border-radius: 3px;
}

/* 🔗 Navigation Links */
.footer-nav ul,
.footer-nav li {
  list-style: none;
  margin: 0;
  padding: 0;
}

.footer-nav a {
  display: block;
  padding: 0.4rem 0;
  color: #ddd;
  text-decoration: none;
  transition: all 0.3s ease;
}

.footer-nav a:hover {
  color: #fff;
  transform: translateX(5px);
}

/* 📍 Contact Info */
.footer-contact p {
  margin: 0.4rem 0;
  display: flex;
  align-items: center;
  gap: 8px;
  color: #ddd;
  font-size: 0.95rem;
}

.footer-contact i {
  color: #ffffff;
  min-width: 20px;
}

/* Buat link dalam kontak supaya warna & hover sesuai */
.footer-contact a {
  color: #ddd;
  text-decoration: none;
  transition: color 0.3s ease;
}

.footer-contact a:hover {
  color: #fff;
  text-decoration: none;
}

/* 📌 Map Embed */
.footer-map iframe {
  width: 100%;
  border-radius: 8px;
  border: none;
  filter: brightness(0.9) contrast(1.1);
}

/* 💬 About & Logo */
.footer-about img {
  width: 150px;
  margin-bottom: 1rem;
}

.footer-about p {
  font-size: 0.95rem;
  color: #e0e0e0;
  margin-bottom: 1rem;
}

/* 🌐 Social Icons */
.footer-socials {
  display: flex;
  gap: 10px;
}

.footer-socials a {
  width: 36px;
  height: 36px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 50%;
  color: #fff;
  display: flex;
  align-items: center;
  text-decoration: none;
  justify-content: center;
  transition: all 0.3s ease;
}

.footer-socials a:hover {
  background: #fff;
  color: #9C27B0;
  transform: scale(1.1) rotate(8deg);
}

/* 🔻 Bottom Text */
.footer-bottom {
  text-align: center;
  padding: 20px 10px 0;
  font-size: 0.85rem;
  color: #cccccc;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  margin-top: 2rem;
}

/* 🔝 Back to Top Button */
.back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background: #9C27B0;
  color: #fff;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 100;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.back-to-top:hover {
  background: #fff;
  color: #9C27B0;
  transform: scale(1.1) rotate(10deg);
}

.back-to-top.show {
  display: flex;
}

/* 📱 Responsive Adjustments */
@media (max-width: 768px) {
  .site-footer {
    padding: 40px 15px 15px;
  }

  .footer-col h4 {
    font-size: 1.1rem;
  }

  .footer-contact p {
    font-size: 0.9rem;
  }

  .footer-about img {
    width: 120px;
  }
}

</style>