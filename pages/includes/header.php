<header role="banner">
  <div class="nav-container">
    <div class="navbar">

      <!-- 🔷 Logo -->
      <div class="logo">
        <h1>
          <a href="/" aria-label="Beranda MHTeams">MHTeams</a>
        </h1>
      </div>

      <!-- 🔷 Burger Menu (Mobile) -->
      <button class="burger-menu" aria-label="Buka atau Tutup Navigasi" aria-expanded="false" aria-controls="main-nav">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>

      <!-- 🔷 Navigation Links -->
      <nav id="main-nav" role="navigation" aria-label="Navigasi Utama" class="nav-links">
        <ul>
          <li><a href="/" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Beranda</a></li>

          <li class="dropdown <?= strpos($_SERVER['REQUEST_URI'], '/tentang') !== false ? 'active' : '' ?>">
            <a href="/tentang-kami" aria-haspopup="true" aria-expanded="false">Tentang</a>
            <ul class="dropdown-menu" aria-label="Submenu Tentang">
              <li><a href="/testimoni">Testimoni</a></li>
              <li><a href="/frequently-asked-question">FAQ</a></li>
            </ul>
          </li>

          <!-- Layanan -->
          <li class="dropdown <?= strpos($_SERVER['REQUEST_URI'], '/proyek-kami') !== false || strpos($_SERVER['REQUEST_URI'], '/paket-kami') !== false ? 'active' : '' ?>">
            <a href="/proyek-kami" aria-haspopup="true" aria-expanded="false">Layanan</a>
            <ul class="dropdown-menu" aria-label="Submenu Layanan">
              <li><a href="/proyek-kami">Proyek Kami</a></li>
              <li><a href="/paket-kami">Paket Website</a></li>
              <!-- <li><a href="/jadwal-temu">Jadwal Temu</a></li> -->
            </ul>
          </li>

          <!-- Kolaborasi
          <li class="dropdown <?= strpos($_SERVER['REQUEST_URI'], '/pengajuan-kolaborasi') !== false ? 'active' : '' ?>">
            <a href="/pengajuan-kolaborasi" aria-haspopup="true" aria-expanded="false">Kolaborasi</a>
            <ul class="dropdown-menu" aria-label="Submenu Kolaborasi">
              <li><a href="/pengajuan-kolaborasi">Ajukan Kerja Sama</a></li>
            </ul>
          </li> -->

          <!-- Kontak
          <li><a href="/kontak" class="<?= strpos($_SERVER['REQUEST_URI'], '/kontak') !== false ? 'active' : '' ?>">Kontak</a></li> -->

          <!-- CTA (Call To Action) -->
          <li>
            <a href="/jadwal-temu" class="nav-cta <?= strpos($_SERVER['REQUEST_URI'], '/jadwal-temu') !== false ? 'active' : '' ?>">Jadwalkan Temu</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</header>
