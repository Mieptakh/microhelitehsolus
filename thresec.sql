-- =====================================================
-- DATABASE: mhteams_db (sesuaikan dengan nama database Anda)
-- =====================================================

-- -----------------------------------------------------
-- Table structure for table `news`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text NOT NULL,
  `content` longtext,
  `category` varchar(100) DEFAULT 'Umum',
  `author` varchar(100) DEFAULT 'Tim MicroHelix',
  `image` varchar(255) DEFAULT 'default-news.jpg',
  `read_time` int(11) DEFAULT 3,
  `views` int(11) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `status` enum('draft','published') DEFAULT 'published',
  `date_published` datetime DEFAULT CURRENT_TIMESTAMP,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_date_published` (`date_published` DESC),
  KEY `idx_category` (`category`),
  KEY `idx_featured` (`is_featured`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Dumping data for table `news`
-- -----------------------------------------------------

INSERT INTO `news` (`title`, `slug`, `excerpt`, `content`, `category`, `author`, `image`, `read_time`, `is_featured`, `date_published`) VALUES
('MicroHelix Luncurkan Layanan Website Baru untuk UMKM', 'microhelix-luncurkan-layanan-website-umkm', 'Layanan website dengan harga terjangkau khusus untuk usaha mikro, kecil, dan menengah agar bisa go digital.', '<p>PT MicroHelix Tech Solutions resmi meluncurkan layanan website baru yang dikhususkan untuk pelaku Usaha Mikro, Kecil, dan Menengah (UMKM) di Indonesia. Layanan ini hadir dengan harga terjangkau namun tetap mengutamakan kualitas dan profesionalisme.</p><p>Dengan paket mulai dari Rp 1,5 juta, pelaku UMKM sudah bisa memiliki website profesional yang dilengkapi dengan fitur-fitur penting seperti: desain responsif, integrasi media sosial, formulir kontak, galeri produk, dan optimasi SEO dasar.</p><p>"Kami memahami bahwa tidak semua pelaku UMKM memiliki budget besar untuk membuat website. Oleh karena itu, kami menghadirkan solusi yang tepat dengan harga yang bersahabat," ujar CEO MicroHelix, Ir. Ach. Miftakhul Huda.</p><p>Layanan ini juga sudah termasuk domain .com atau .id gratis untuk tahun pertama, hosting dengan SSD, SSL certificate, serta dukungan teknis selama 30 hari. Untuk informasi lebih lanjut, kunjungi halaman paket kami.</p>', 'Layanan Baru', 'Tim MicroHelix', 'news-umkm.jpg', 3, 1, '2026-02-18 09:00:00'),
('Kolaborasi MicroHelix dengan Komunitas Developer Sidoarjo', 'kolaborasi-microhelix-komunitas-developer-sidoarjo', 'MicroHelix resmi menjalin kerjasama dengan komunitas developer Sidoarjo untuk mengembangkan ekosistem digital lokal.', '<p>PT MicroHelix Tech Solutions secara resmi menjalin kerjasama strategis dengan Komunitas Developer Sidoarjo (KODES). Kerjasama ini bertujuan untuk mengembangkan ekosistem digital di wilayah Sidoarjo dan sekitarnya.</p><p>Dalam kerjasama ini, MicroHelix akan menjadi mentor dan sponsor untuk berbagai kegiatan komunitas, termasuk workshop, coding camp, dan hackathon. Sementara itu, KODES akan menjadi mitra dalam pengembangan proyek-proyek open source dan rekrutmen talenta digital.</p><p>"Kami sangat antusias dengan kerjasama ini. Komunitas developer adalah tempat lahirnya inovasi dan talenta-talenta hebat. Dengan berkolaborasi bersama KODES, kami berharap dapat mencetak lebih banyak developer berkualitas di Sidoarjo," kata M. Ihsan, Head of R&D MicroHelix.</p><p>Kegiatan pertama yang akan digelar adalah "Web Development Bootcamp" pada bulan Maret 2026 yang akan diadakan secara gratis untuk anggota komunitas.</p>', 'Kolaborasi', 'Tim MicroHelix', 'news-kolaborasi.jpg', 2, 1, '2026-02-15 10:30:00'),
('Tips Memilih Paket Website yang Tepat untuk Bisnis Anda', 'tips-memilih-paket-website-tepat-bisnis', 'Panduan lengkap memilih paket website sesuai kebutuhan bisnis, dari pemula hingga enterprise.', '<p>Memilih paket website yang tepat bisa menjadi tantangan tersendiri, terutama bagi pemilik bisnis yang baru pertama kali membuat website. Berikut adalah panduan lengkap dari tim MicroHelix untuk membantu Anda memilih paket yang sesuai.</p><p><strong>1. Tentukan Tujuan Website Anda</strong><br>Apakah Anda hanya butuh company profile sederhana, atau membutuhkan toko online dengan fitur pembayaran? Tujuan akan menentukan fitur apa saja yang diperlukan.</p><p><strong>2. Pertimbangkan Budget</strong><br>Sesuaikan paket dengan anggaran yang tersedia. Ingat bahwa website adalah investasi jangka panjang untuk bisnis Anda.</p><p><strong>3. Perhatikan Skalabilitas</strong><br>Pilih paket yang bisa dikembangkan seiring pertumbuhan bisnis. Jangan sampai website Anda tidak bisa menampung traffic yang semakin besar.</p><p><strong>4. Cek Fitur yang Ditawarkan</strong><br>Pastikan paket yang dipilih mencakup fitur-fitur penting seperti hosting, domain, SSL, maintenance, dan dukungan teknis.</p><p><strong>5. Konsultasi dengan Tim Ahli</strong><br>Tim MicroHelix siap membantu Anda berkonsultasi gratis untuk menentukan paket yang paling sesuai dengan kebutuhan bisnis.</p>', 'Tips', 'Tim MicroHelix', 'news-tips.jpg', 5, 0, '2026-02-10 14:15:00'),
('MicroHelix Raih Penghargaan Inovasi Digital 2026', 'microhelix-raih-penghargaan-inovasi-digital-2026', 'PT MicroHelix Tech Solutions menerima penghargaan sebagai perusahaan teknologi paling inovatif di Sidoarjo.', '<p>PT MicroHelix Tech Solutions baru saja menerima penghargaan "Inovasi Digital 2026" dari Dinas Komunikasi dan Informatika Kabupaten Sidoarjo. Penghargaan ini diberikan atas kontribusi perusahaan dalam mengembangkan solusi digital bagi UMKM di wilayah Sidoarjo.</p><p>Penghargaan diserahkan langsung oleh Bupati Sidoarjo dalam acara Sidoarjo Digital Summit 2026 yang digelar di Convention Hall Sidoarjo. MicroHelix dinilai berhasil menciptakan platform yang membantu ribuan UMKM untuk go digital.</p><p>"Kami sangat bersyukur dan bangga atas penghargaan ini. Ini menjadi motivasi bagi kami untuk terus berinovasi dan memberikan yang terbaik bagi masyarakat, terutama pelaku UMKM," ujar Ir. Ach. Miftakhul Huda usai menerima penghargaan.</p>', 'Penghargaan', 'Tim MicroHelix', 'news-award.jpg', 2, 1, '2026-02-05 11:00:00'),
('MicroHelix Buka Lowongan untuk Developer Baru', 'microhelix-buka-lowongan-developer-baru', 'PT MicroHelix Tech Solutions membuka kesempatan bagi developer berbakat untuk bergabung dalam tim.', '<p>Seiring dengan pertumbuhan perusahaan, PT MicroHelix Tech Solutions membuka lowongan untuk posisi Web Developer, Frontend Developer, dan UI/UX Designer. Ini adalah kesempatan emas bagi para talenta digital yang ingin berkarier di perusahaan teknologi yang sedang berkembang pesat.</p><p>Kualifikasi umum yang dibutuhkan antara lain: pengalaman minimal 1 tahun di bidang terkait, menguasai teknologi terkini, memiliki portofolio yang baik, dan kemampuan bekerja dalam tim.</p><p>Bagi yang berminat, dapat mengirimkan CV dan portofolio ke email: career@microhelix.tech paling lambat 15 Maret 2026. Proses rekrutmen akan dilakukan secara online dan offline.</p>', 'Karir', 'Tim HR MicroHelix', 'news-career.jpg', 3, 0, '2026-02-01 09:45:00');

-- -----------------------------------------------------
-- Table structure for table `gallery`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text,
  `category` varchar(100) DEFAULT 'Umum',
  `image` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `date_taken` date DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `sort_order` int(11) DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_category` (`category`),
  KEY `idx_featured` (`is_featured`),
  KEY `idx_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Dumping data for table `gallery`
-- -----------------------------------------------------

INSERT INTO `gallery` (`title`, `slug`, `description`, `category`, `image`, `thumbnail`, `date_taken`, `is_featured`, `sort_order`) VALUES
('Workshop Web Development Batch 1', 'workshop-web-development-batch-1', 'Suasana workshop web development yang diadakan di kantor MicroHelix pada 10 Februari 2026. Peserta sangat antusias belajar HTML, CSS, dan JavaScript.', 'Workshop', 'gallery-workshop-1.jpg', 'gallery-workshop-1-thumb.jpg', '2026-02-10', 1, 1),
('Team Building MicroHelix', 'team-building-microhelix', 'Kegiatan team building tim MicroHelix di Taman Safari Prigen. Momen kebersamaan dan kekompakan tim.', 'Internal', 'gallery-teambuilding.jpg', 'gallery-teambuilding-thumb.jpg', '2026-01-25', 1, 2),
('Meeting dengan Klien', 'meeting-dengan-klien', 'Sesi meeting dengan klien dari PT Maju Jaya untuk membahas pengembangan sistem inventory.', 'Klien', 'gallery-meeting.jpg', 'gallery-meeting-thumb.jpg', '2026-02-05', 1, 3),
('Coding Session', 'coding-session', 'Tim developer MicroHelix sedang fokus mengerjakan project website untuk klien. Suasana kerja yang produktif.', 'Development', 'gallery-coding.jpg', 'gallery-coding-thumb.jpg', '2026-02-08', 0, 4),
('Presentasi Proyek', 'presentasi-proyek', 'Presentasi hasil proyek website e-commerce kepada klien. Semua fitur berjalan dengan baik dan klien puas.', 'Klien', 'gallery-presentasi.jpg', 'gallery-presentasi-thumb.jpg', '2026-02-12', 1, 5),
('Diskusi Tim', 'diskusi-tim', 'Diskusi tim untuk merencanakan fitur baru pada platform MicroHelix. Kolaborasi dan brainstorming ide.', 'Internal', 'gallery-diskusi.jpg', 'gallery-diskusi-thumb.jpg', '2026-02-14', 0, 6),
('Launching Layanan UMKM', 'launching-layanan-umkm', 'Acara launching layanan website untuk UMKM yang dihadiri oleh puluhan pelaku usaha kecil.', 'Event', 'gallery-launching.jpg', 'gallery-launching-thumb.jpg', '2026-02-18', 1, 7),
('Hackathon Sidoarjo', 'hackathon-sidoarjo', 'MicroHelix menjadi sponsor utama Hackathon Sidoarjo 2026. Puluhan tim developer berlomba menciptakan inovasi.', 'Event', 'gallery-hackathon.jpg', 'gallery-hackathon-thumb.jpg', '2026-01-30', 1, 8),
('Office Tour', 'office-tour', 'Suasana kantor MicroHelix yang nyaman dan modern, dilengkapi dengan fasilitas pendukung kerja.', 'Internal', 'gallery-office.jpg', 'gallery-office-thumb.jpg', '2026-02-01', 0, 9);

-- -----------------------------------------------------
-- Table structure for table `events`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT 'Seminar',
  `image` varchar(255) DEFAULT 'default-event.jpg',
  `date_start` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `location_url` varchar(500) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `registered` int(11) DEFAULT 0,
  `price` decimal(10,2) DEFAULT 0.00,
  `is_free` tinyint(1) DEFAULT 1,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `featured` tinyint(1) DEFAULT 0,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_date_start` (`date_start`),
  KEY `idx_status` (`status`),
  KEY `idx_featured` (`featured`),
  KEY `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------------------------------
-- Dumping data for table `events`
-- -----------------------------------------------------

INSERT INTO `events` (`title`, `slug`, `description`, `short_description`, `category`, `image`, `date_start`, `date_end`, `time_start`, `time_end`, `location`, `capacity`, `registered`, `is_free`, `status`, `featured`, `contact_person`) VALUES
('Web Development Bootcamp 2026', 'web-development-bootcamp-2026', 'Pelatihan intensif menjadi web developer profesional dalam 12 minggu. Program ini dirancang untuk pemula yang ingin memulai karir sebagai web developer. Peserta akan belajar HTML, CSS, JavaScript, PHP, Laravel, dan database MySQL. Di akhir program, peserta akan membuat proyek akhir berupa website e-commerce lengkap.', 'Pelatihan intensif 12 minggu untuk menjadi web developer profesional. Cocok untuk pemula.', 'Bootcamp', 'event-bootcamp.jpg', '2026-03-15', '2026-06-07', '09:00:00', '16:00:00', 'Online via Zoom dan MicroHelix Office', 50, 32, 1, 'ongoing', 1, 'M. Ihsan'),
('Seminar Digital Marketing untuk UMKM', 'seminar-digital-marketing-umkm', 'Strategi jitu memasarkan produk secara online dengan anggaran terbatas. Seminar ini akan membahas teknik-teknik digital marketing yang efektif untuk UMKM, termasuk social media marketing, content marketing, email marketing, dan Google Ads. Dibawakan oleh praktisi digital marketing berpengalaman.', 'Strategi pemasaran online efektif dengan budget terbatas untuk UMKM.', 'Seminar', 'event-seminar.jpg', '2026-03-22', '2026-03-22', '13:00:00', '17:00:00', 'Gedung Inovasi, Sidoarjo', 100, 45, 1, 'upcoming', 1, 'Diana Putri'),
('Tech Meetup: MicroHelix Community', 'tech-meetup-microhelix-community', 'Temu komunitas developer Sidoarjo, berbagi pengalaman, dan networking dengan para ahli di bidang teknologi. Acara ini akan diisi dengan talkshow, sharing session, dan networking. Topik yang akan dibahas antara lain: tren teknologi terbaru, tips membangun karir di IT, dan peluang bisnis di bidang teknologi.', 'Ngobrol santai seputar teknologi bersama komunitas developer Sidoarjo.', 'Meetup', 'event-meetup.jpg', '2026-04-05', '2026-04-05', '15:00:00', '18:00:00', 'MicroHelix Office, Sidoarjo', 30, 18, 1, 'upcoming', 1, 'M. Imron Rosyadi'),
('Workshop Laravel untuk Pemula', 'workshop-laravel-untuk-pemula', 'Workshop pengenalan framework Laravel untuk pemula. Peserta akan belajar dasar-dasar Laravel, MVC, routing, migration, eloquent ORM, dan membuat aplikasi CRUD sederhana. Workshop ini cocok untuk yang sudah mengenal PHP dasar.', 'Belajar framework Laravel dari dasar dalam satu hari.', 'Workshop', 'event-laravel.jpg', '2026-04-12', '2026-04-12', '09:00:00', '16:00:00', 'MicroHelix Office, Sidoarjo', 25, 10, 1, 'upcoming', 0, 'M. Ihsan'),
('Hackathon Inovasi Digital 2026', 'hackathon-inovasi-digital-2026', 'Kompetisi coding 24 jam untuk menciptakan solusi digital bagi permasalahan di Sidoarjo. Tema hackathon kali ini adalah "Smart City Solutions". Peserta akan berlomba membuat aplikasi inovatif dalam waktu 24 jam. Total hadiah puluhan juta rupiah.', 'Kompetisi coding 24 jam dengan total hadiah puluhan juta.', 'Hackathon', 'event-hackathon.jpg', '2026-04-25', '2026-04-26', '08:00:00', '08:00:00', 'Convention Hall Sidoarjo', 200, 67, 1, 'upcoming', 1, 'Ir. Ach. Miftakhul Huda'),
('Webinar: Tips Sukses Freelance Developer', 'webinar-tips-sukses-freelance-developer', 'Webinar gratis tentang tips dan trik menjadi freelance developer sukses. Pembicara akan berbagi pengalaman tentang cara mendapatkan klien, menentukan harga, mengelola proyek, dan membangun personal branding sebagai freelancer.', 'Tips menjadi freelance developer sukses dari para ahli.', 'Webinar', 'event-webinar.jpg', '2026-03-08', '2026-03-08', '19:00:00', '21:00:00', 'Online via Zoom', 500, 234, 1, 'ongoing', 1, 'Tim MicroHelix'),
('Pelatihan UI/UX Design', 'pelatihan-ui-ux-design', 'Pelatihan dasar-dasar UI/UX design selama 2 hari. Peserta akan belajar prinsip desain, wireframing, prototyping, dan user research. Cocok untuk desainer pemula yang ingin memperdalam skill UI/UX.', 'Pelatihan intensif UI/UX design selama 2 hari.', 'Pelatihan', 'event-ux.jpg', '2026-05-10', '2026-05-11', '09:00:00', '16:00:00', 'MicroHelix Office, Sidoarjo', 20, 8, 0, 'upcoming', 0, 'Tim MicroHelix'),
('MicroHelix Anniversary 1 Tahun', 'microhelix-anniversary-1-tahun', 'Perayaan ulang tahun pertama MicroHelix! Acara akan diisi dengan berbagai kegiatan menarik, doorprize, dan networking. Terbuka untuk klien, mitra, dan masyarakat umum.', 'Rayakan ulang tahun pertama MicroHelix bersama-sama.', 'Celebration', 'event-anniv.jpg', '2025-12-05', '2025-12-05', '14:00:00', '18:00:00', 'MicroHelix Office, Sidoarjo', 100, 89, 1, 'completed', 1, 'Ir. Ach. Miftakhul Huda');

-- -----------------------------------------------------
-- Indexes for performance
-- -----------------------------------------------------
ALTER TABLE `news` ADD FULLTEXT INDEX `ft_search` (`title`, `excerpt`, `content`);
ALTER TABLE `events` ADD INDEX `idx_date_status` (`date_start`, `status`);
ALTER TABLE `gallery` ADD INDEX `idx_category_sort` (`category`, `sort_order`);