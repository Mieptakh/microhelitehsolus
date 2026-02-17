<footer class="site-footer">
  <div class="container footer-container">
    <!-- Logo & About -->
    <div class="footer-col footer-about">
      <a href="/" class="footer-logo">
        <img src="/logo\20250320_190104[1].png" alt="Logo MHTeams" />
      </a>
      <p>MHTeams - Solusi digital terpercaya untuk kebutuhan website dan teknologi Anda.</p>
      <div class="footer-socials">
        <a href="https://instagram.com/mh.teams" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
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
        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d206.35130866919107!2d112.71928040121746!3d-7.491262285050211!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sid!2sid!4v1753502228187!5m2!1sid!2sid"
        width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; 2025 MHTeams. Semua hak dilindungi.</p>
  </div>

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
