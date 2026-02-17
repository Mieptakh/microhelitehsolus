<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include __DIR__ . '/../webmaster/includes/db.php'; ?>

<!-- FAQ Section -->
<section class="faq-section">
  <div class="container">
    <h1 class="faq-title">Frequently Asked Questions</h1>
    <p class="faq-subtitle">Pertanyaan yang sering diajukan seputar <b>MHTeams</b>.</p>

    <div class="faq-container">

      <!-- Item -->
      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="info"></i>
          <span>Apa itu MHTeams?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <p>MHTeams adalah tim pengembang digital yang fokus pada pembuatan website modern, aplikasi interaktif, serta solusi berbasis teknologi untuk bisnis maupun personal.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="calendar"></i>
          <span>Sejak kapan MHTeams berdiri?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <p>Kami berdiri pada tahun <b>2024</b>, berawal dari komunitas kecil pecinta teknologi, dan berkembang menjadi tim profesional dengan berbagai proyek digital nyata.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="layers"></i>
          <span>Apa layanan utama yang ditawarkan?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <ul>
            <li><i data-lucide="globe"></i> Pengembangan Website (Company Profile, Landing Page, School Web)</li>
            <li><i data-lucide="cog"></i> Pembuatan Sistem Informasi Custom</li>
            <li><i data-lucide="palette"></i> Desain Branding & UI/UX</li>
            <li><i data-lucide="trending-up"></i> Konsultasi & Optimasi Website</li>
          </ul>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="file-plus"></i>
          <span>Apakah bisa request custom project?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <p>Ya, kami menerima request khusus sesuai kebutuhan bisnis, organisasi, atau personal dengan alur diskusi, perencanaan, hingga implementasi yang transparan.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="headphones"></i>
          <span>Apakah ada support setelah project selesai?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <p>Kami menyediakan support berupa maintenance, perbaikan bug, update fitur, serta panduan penggunaan agar project tetap berjalan lancar.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="wallet"></i>
          <span>Berapa kisaran harga layanan MHTeams?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <p>Kami menyediakan paket mulai dari basic hingga paket bisnis lengkap. Detail harga bisa dilihat di halaman <a href="/paket-kami">Daftar Paket</a>.</p>
        </div>
      </div>

      <div class="faq-item">
        <button class="faq-question">
          <i data-lucide="map-pin"></i>
          <span>Dimana lokasi MHTeams?</span>
          <i class="faq-toggle" data-lucide="plus"></i>
        </button>
        <div class="faq-answer">
          <p>Kami bekerja secara remote dengan anggota tim dari berbagai kota, namun tetap siap meeting online maupun offline sesuai kebutuhan client.</p>
        </div>
      </div>

    </div>
  </div>
</section>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

body { font-family: 'Poppins', sans-serif; background: #f5f5f7; margin:0; }

/* FAQ Section */
.faq-section {
    padding: 80px 20px;
    background: #f0f0f8;
}

.faq-title {
    text-align: center;
    font-size: 2.6rem;
    font-weight: 700;
    color: #8e44ad;
    margin-bottom: 10px;
}

.faq-subtitle {
    text-align: center;
    font-size: 1rem;
    color: #555;
    margin-bottom: 50px;
}

.faq-container {
    max-width: 800px;
    margin: 0 auto;
}

.faq-item {
    background: #fff;
    border-radius: 15px;
    margin-bottom: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.faq-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.faq-question {
    width: 100%;
    background: none;
    border: none;
    outline: none;
    text-align: left;
    font-size: 1.1rem;
    font-weight: 600;
    padding: 20px 30px;
    cursor: pointer;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background 0.3s ease;
}

.faq-question:hover {
    background: rgba(142, 68, 173, 0.05);
}

.faq-question span {
    flex: 1;
    margin: 0 15px;
}

.faq-question i {
    color: #8e44ad;
    flex-shrink: 0;
    transition: transform 0.3s ease;
}

.faq-toggle {
    transition: transform 0.3s ease;
}

.faq-answer {
    max-height: 0;
    overflow: hidden;
    padding: 0 30px;
    background: #fafafa;
    color: #555;
    line-height: 1.7;
    font-size: 0.95rem;
    transition: max-height 0.4s ease, padding 0.3s ease;
}

.faq-answer.open {
    padding: 15px 30px 25px 30px;
    max-height: 500px; /* cukup untuk satu jawaban */
}

.faq-answer ul {
    margin: 10px 0 0 0;
    padding-left: 20px;
    list-style: disc;
}

.faq-answer ul li {
    margin-bottom: 8px;
}
</style>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
lucide.createIcons();

// Toggle FAQ
document.querySelectorAll('.faq-question').forEach(btn => {
  btn.addEventListener('click', () => {
    const answer = btn.nextElementSibling;
    const toggleIcon = btn.querySelector('.faq-toggle');

    // Jika sudah terbuka, tutup
    if(answer.classList.contains('open')){
        answer.classList.remove('open');
        toggleIcon.setAttribute("data-lucide","plus");
    } else {
        // Tutup semua lainnya
        document.querySelectorAll('.faq-answer').forEach(a => a.classList.remove('open'));
        document.querySelectorAll('.faq-toggle').forEach(i => i.setAttribute("data-lucide","plus"));

        // Buka ini
        answer.classList.add('open');
        toggleIcon.setAttribute("data-lucide","minus");
    }
    lucide.createIcons();
  });
});
</script>


<?php include 'includes/footer.php'; ?>
