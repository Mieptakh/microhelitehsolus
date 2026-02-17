<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include __DIR__ . '/../webmaster/includes/db.php'; ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

:root {
  --primary: #9C27B0;
  --hover: #7B1FA2;
  --accent: #FFD700; /* Ganti ke emas */
  --bg-light: #F9F9F9;
  --bg-dark: #121212;
  --text-grey: #666;
}

body {
  font-family: 'Poppins', sans-serif;
  color: #333;
  line-height: 1.7;
}

/* Animation */
@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(30px); }
  100% { opacity: 1; transform: translateY(0); }
}

/* Hero */
.hero-section {
  padding: 120px 20px;
  text-align: center;
  background: linear-gradient(135deg, #fafafa, #fff);
  animation: fadeUp 1s ease-out;
}
.hero-section h1 {
  font-size: 3rem;
  font-weight: 700;
}
.hero-section .highlight {
  color: var(--primary);
}
.hero-section p {
  max-width: 750px;
  margin: 20px auto 0;
  font-size: 1.15rem;
  color: var(--text-grey);
}

/* Sejarah */
.about-history {
  padding: 80px 20px;
  animation: fadeUp 1.2s ease-out;
}
.about-history h2 {
  font-size: 2.2rem;
  margin-bottom: 20px;
  color: var(--primary);
}

/* Tim */
.about-team {
  padding: 80px 20px;
  background: var(--bg-light);
  text-align: center;
  animation: fadeUp 1.4s ease-out;
}
.about-team h2 {
  color: var(--primary);
  font-size: 2.2rem;
}
.team-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 30px;
  margin-top: 40px;
}
.team-card {
  background: #fff;
  padding: 30px;
  border-radius: 14px;
  box-shadow: 0 6px 14px rgba(0,0,0,0.05);
  transition: all .4s ease;
  border: 2px solid transparent;
}
.team-card:hover {
  transform: translateY(-8px);
  border-color: var(--accent);
  box-shadow: 0 12px 25px rgba(255, 215, 0, 0.25);
}
.team-card h3 {
  color: var(--primary);
  margin-bottom: 8px;
  font-weight: 600;
}

/* Visi & Misi */
.about-vision {
  padding: 80px 20px;
  animation: fadeUp 1.6s ease-out;
}
.about-vision h2 {
  color: var(--primary);
  margin-bottom: 25px;
  font-size: 2.2rem;
}
.about-vision ul {
  margin-top: 20px;
  padding-left: 20px;
  list-style: none;
}
.about-vision ul li {
  margin-bottom: 12px;
  position: relative;
  padding-left: 25px;
}
.about-vision ul li::before {
  content: "✔";
  color: var(--accent); /* Ikon checklist jadi emas */
  position: absolute;
  left: 0;
  top: 0;
}

/* Mengapa Memilih Kami */
.about-extra {
  padding: 80px 20px;
  background: var(--bg-light);
  animation: fadeUp 1.8s ease-out;
}
.about-extra h2 {
  color: var(--primary);
  margin-bottom: 40px;
  font-size: 2.2rem;
  text-align: center;
}
.extra-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 30px;
}
.extra-card {
  background: #fff;
  padding: 30px;
  border-radius: 14px;
  text-align: center;
  box-shadow: 0 6px 14px rgba(0,0,0,0.05);
  transition: all .4s ease;
}
.extra-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 25px rgba(255, 215, 0, 0.3);
}
.extra-card i {
  font-size: 2.2rem;
  color: var(--accent); /* Ikon emas */
  margin-bottom: 18px;
}
.extra-card h4 {
  margin-bottom: 12px;
  color: var(--primary);
  font-weight: 600;
}
</style>


<main class="about-page">

  <!-- Hero -->
  <section class="hero-section">
    <div class="container">
      <h1>
        Tentang <span class="highlight">MHTeams</span>
      </h1>
      <p>
        Kami adalah tim inovatif yang berfokus pada pengembangan website modern, solusi digital,
        dan integrasi teknologi AI untuk membantu bisnis dan individu bersaing di era digital.
      </p>
    </div>
  </section>

  <!-- Sejarah -->
  <section class="about-history">
    <div class="container">
      <h2>Sejarah Kami</h2>
      <p>
        <strong>MHTeams</strong> lahir dari sebuah komunitas kecil yang didirikan oleh
        <strong>Miftakhul Huda</strong> dengan semangat untuk belajar, berkolaborasi, dan berbagi pengetahuan
        tentang pengembangan website serta pemanfaatan Artificial Intelligence.
        Kini, MHTeams berkembang menjadi tim solid dengan pengalaman dalam membangun website, UI/UX, riset
        teknologi, hingga konsultasi digital.
      </p>
    </div>
  </section>

  <!-- Tim -->
  <section class="about-team">
    <div class="container">
      <h2>Tim Kami</h2>
      <p class="subtitle">Orang-orang di balik inovasi MHTeams:</p>
      
      <div class="team-grid">
        <div class="team-card">
          <h3>Ach. Miftakhul Huda</h3>
          <p>Founder, Prompt Engineer & Prompt Engineer</p>
        </div>
        <div class="team-card">
          <h3>M. Ihsan</h3>
          <p>Graphic Design</p>
        </div>
        <div class="team-card">
          <h3>M. Imron Rosyadi</h3>
          <p>Tester and Webmaster</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Visi & Misi -->
  <section class="about-vision">
    <div class="container">
      <h2>Visi & Misi</h2>
      <p><strong>Visi:</strong> Menjadi tim teknologi terdepan yang menghadirkan solusi digital kreatif, inovatif, dan bermanfaat untuk semua kalangan.</p>
      <p><strong>Misi:</strong></p>
      <ul>
        <li>Menyediakan layanan pembuatan website modern, responsif, dan sesuai kebutuhan.</li>
        <li>Mendukung UMKM & individu membangun identitas digital yang profesional.</li>
        <li>Mengintegrasikan teknologi AI untuk efisiensi dan daya saing bisnis.</li>
        <li>Mengedepankan inovasi dan pembelajaran berkelanjutan dalam setiap project.</li>
      </ul>
    </div>
  </section>

  <!-- Mengapa Memilih Kami -->
  <section class="about-extra">
    <div class="container">
      <h2>Mengapa Memilih Kami?</h2>
      <div class="extra-grid">
        <div class="extra-card">
          <i class="fa-solid fa-user-tie"></i>
          <h4>Profesional</h4>
          <p>Tim kami bekerja dengan standar kualitas tinggi untuk setiap project.</p>
        </div>
        <div class="extra-card">
          <i class="fa-solid fa-bullseye"></i>
          <h4>Fokus pada Hasil</h4>
          <p>Setiap solusi yang kami buat dirancang untuk mencapai tujuan bisnis klien.</p>
        </div>
        <div class="extra-card">
          <i class="fa-solid fa-handshake"></i>
          <h4>Dukungan Penuh</h4>
          <p>Kami memberikan support setelah project selesai agar klien nyaman.</p>
        </div>
        <div class="extra-card">
          <i class="fa-solid fa-lightbulb"></i>
          <h4>Inovatif</h4>
          <p>Kami selalu mengikuti perkembangan teknologi dan tren digital terbaru.</p>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include 'includes/footer.php'; ?>
