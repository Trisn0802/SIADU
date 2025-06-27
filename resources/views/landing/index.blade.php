<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />

    {{-- Logo Aplikasi --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/logo.png') }}">
    {{-- Font Poppins --}}
    <link rel="stylesheet" href="{{ asset('font/poppins-font.css') }}">

    <title>SIADU - Sistem Informasi Aduan Masyarakat</title>
</head>

<body>
  <!-- hero section -->
  <section class="bg-primary text-white position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-10"></div>
    <div class="container position-relative py-5">
      <div class="row min-vh-100 align-items-center">
        <div class="col-12 text-center py-5">
          <h1 class="display-1 fw-bold mb-4 col-12">
            SIADU
            <br>
            <img class="bg-white rounded-circle mb-4 mt-4" src="{{ asset('image/logo.png') }}" alt="SIADU" style="width: 100px">
            <div class="display-4 fw-normal mt-2 text-primary-emphasis">Sistem Informasi Aduan Masyarakat</div>
          </h1>
          <p class="lead fs-3 mb-5 text-light mx-auto">
            Wadah digital yang memudahkan masyarakat untuk menyampaikan aduan kepada instansi terkait dengan cepat,
            transparan, dan akuntabel.
          </p>
          <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mb-5">
            <button class="btn btn-light btn-lg px-4 py-3" onclick="window.location='{{ route('backend.login') }}'">
                <i class="bi bi-play-circle me-2"></i>
                Mulai Lapor Sekarang
            </button>
            <button class="btn btn-outline-light btn-lg px-4 py-3" onclick="scrollToSection('pelajariLebihLanjut')">
                <i class="bi bi-info-circle me-2"></i>
                Pelajari Lebih Lanjut
            </button>
          </div>

          <div class="row g-4 mt-5">
            <div class="col-6 col-md-3">
              <div class="text-center">
                <i class="bi bi-chat-square-text display-4 text-primary-emphasis mb-3"></i>
                <div class="h2 fw-bold">24/7</div>
                <div class="text-primary-emphasis">Layanan Online</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="text-center">
                <i class="bi bi-people display-4 text-primary-emphasis mb-3"></i>
                <div class="h2 fw-bold">Mudah</div>
                <div class="text-primary-emphasis">Untuk Semua</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="text-center">
                <i class="bi bi-shield-check display-4 text-primary-emphasis mb-3"></i>
                <div class="h2 fw-bold">Aman</div>
                <div class="text-primary-emphasis">& Terpercaya</div>
              </div>
            </div>
            <div class="col-6 col-md-3">
              <div class="text-center">
                <i class="bi bi-lightning display-4 text-primary-emphasis mb-3"></i>
                <div class="h2 fw-bold">Cepat</div>
                <div class="text-primary-emphasis">Ditanggapi</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- about section -->
  <section class="py-5 bg-light" id="pelajariLebihLanjut">
    <div class="container py-5">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <h2 class="display-4 fw-bold text-dark mb-4">Tentang SIADU</h2>
          <p class="lead fs-4 text-muted mx-auto">
            SIADU adalah sistem berbasis layanan dan informasi yang memberikan layanan pelaporan aduan masyarakat
            serta menyediakan status aduan, riwayat laporan, dan pengumuman penanganan kasus.
          </p>
        </div>
      </div>

      <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-lg">
            <div class="card-body text-center p-4">
              <i class="bi-bullseye display-4 text-primary mb-4"></i>
              <h5 class="card-title fw-semibold mb-3">Wadah Digital Terpadu</h5>
              <p class="card-text text-muted">Menyediakan platform digital yang memudahkan masyarakat menyampaikan aduan
                kepada instansi terkait</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-lg">
            <div class="card-body text-center p-4">
              <i class="bi-lightning display-4 text-primary mb-4"></i>
              <h5 class="card-title fw-semibold mb-3">Proses Cepat</h5>
              <p class="card-text text-muted">Mempercepat proses penanganan dan tindak lanjut terhadap aduan masyarakat
              </p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-lg">
            <div class="card-body text-center p-4">
              <i class="bi-eye display-4 text-primary mb-4"></i>
              <h5 class="card-title fw-semibold mb-3">Transparansi Tinggi</h5>
              <p class="card-text text-muted">Meningkatkan transparansi dan akuntabilitas instansi dalam menyelesaikan
                laporan</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card h-100 border-0 shadow-lg">
            <div class="card-body text-center p-4">
              <i class="bi-people display-4 text-primary mb-4"></i>
              <h5 class="card-title fw-semibold mb-3">Birokrasi Efisien</h5>
              <p class="card-text text-muted">Mengurangi birokrasi berbelit dalam proses pelaporan secara konvensional
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
              <div class="row g-4">
                <div class="col-12 col-lg-4 text-center">
                  <h5 class="fw-semibold mb-3">Target Pengguna</h5>
                  <ul class="list-unstyled text-muted">
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Masyarakat umum
                    </li>
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Petugas instansi pemerintah
                    </li>
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Pemerintah daerah
                    </li>
                  </ul>
                </div>
                <div class="col-12 col-lg-4 text-center">
                  <h5 class="fw-semibold mb-3">Jenis Layanan</h5>
                  <ul class="list-unstyled text-muted">
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Berbasis Layanan
                    </li>
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Berbasis Informasi
                    </li>
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Platform Digital
                    </li>
                  </ul>
                </div>
                <div class="col-12 col-lg-4 text-center">
                  <h5 class="fw-semibold mb-3">Keunggulan</h5>
                  <ul class="list-unstyled text-muted">
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Responsif & User-friendly
                    </li>
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Formal namun ramah
                    </li>
                    <li class="mb-2">
                      <i class="bi bi-check-circle text-primary me-2"></i>
                      Desain profesional
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- features section -->
  <section class="py-5 bg-white">
    <div class="container py-5">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <h2 class="display-4 fw-bold text-dark mb-4">Fitur Unggulan SIADU</h2>
          <p class="lead fs-4 text-muted mx-auto">
            Sistem lengkap dengan berbagai fitur canggih untuk memudahkan proses pelaporan dan penanganan aduan
            masyarakat
          </p>
        </div>
      </div>

      <div class="row g-4 mb-5">
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3"><i class="bi-file-text fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Form Aduan Online</h5>
                </div>
                <p class="card-text text-muted">Formulir pelaporan lengkap dengan upload foto dan
                  lokasi kejadian</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    {{-- <i class="bi-person-check fs-2 text-primary me-3"></i> --}}
                    <i class="bi bi-person fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Login &amp; Registrasi</h5>
                </div>
                <p class="card-text text-muted">Sistem akun pengguna dengan pelaporan menggunakan akun sendiri</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3"><i class="bi-speedometer2 fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">UI Responsif</h5>
                </div>
                <p class="card-text text-muted">Tampilan yang ramah pengguna dan multi platform</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    {{-- <i class="bi-shield-lock fs-2 text-primary me-3"></i> --}}
                    <i class="bi bi-display fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Dashboard Admin</h5>
                </div>
                <p class="card-text text-muted">Panel admin untuk mengelola aduan masuk dengan
                  multi-level akses</p>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3"><i class="bi-bell fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Notifikasi Real-time</h5>
                </div>
                <p class="card-text text-muted">Update status laporan secara berkala melalui email
                  dan dashboard</p>
              </div>
            </div>
          </div>
          {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3"><i class="bi-search fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Filter &amp; Pencarian</h5>
                </div>
                <p class="card-text text-muted">Cari aduan berdasarkan kategori, wilayah, atau
                  status penanganan</p>
              </div>
            </div>
          </div> --}}
          <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    {{-- <i class="bi-bar-chart fs-2 text-primary me-3"></i> --}}
                    <i class="bi bi-clock-history fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Riwayat Aduan &amp; Tindakan</h5>
                </div>
                <p class="card-text text-muted">Mampu melihat progress tindakan dan aduan yang di ajukan</p>
              </div>
            </div>
          </div>
          {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3"><i class="bi-download fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Export Laporan</h5>
                </div>
                <p class="card-text text-muted">Unduh laporan dalam format Excel/PDF untuk
                  keperluan internal</p>
              </div>
            </div>
          </div> --}}
          {{-- <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-start border-primary border-4 shadow">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3"><i class="bi-geo-alt fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0 fw-semibold">Lokasi GPS</h5>
                </div>
                <p class="card-text text-muted">Integrasi peta untuk menandai lokasi kejadian
                  secara akurat</p>
              </div>
            </div>
          </div> --}}
        </div>
      {{-- <div class="row g-4 mb-5">
      </div> --}}

      <div class="row">
        <div class="col-12">
          <div class="bg-primary bg-opacity-10 rounded p-5">
            <div class="row g-5 align-items-center">
              <div class="col-12 col-lg-6">
                <h3 class="h2 fw-bold text-dark mb-4">Fitur yang Diharapkan Pengguna</h3>
                <ul class="list-unstyled">

                  <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-chat-square-text text-primary me-3 mt-1"></i>
                    <span class="text-muted">Formulir pelaporan yang mudah diisi dan jelas</span>
                  </li>
                  <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-chat-square-text text-primary me-3 mt-1"></i>
                    <span class="text-muted">Notifikasi otomatis saat aduan diproses</span>
                  </li>
                  <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-chat-square-text text-primary me-3 mt-1"></i>
                    <span class="text-muted">Riwayat aduan yang dapat dilihat kapan saja</span>
                  </li>
                  <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-chat-square-text text-primary me-3 mt-1"></i>
                    <span class="text-muted">Status laporan real-time (diterima, diproses, selesai)</span>
                  </li>
                  {{-- <li class="d-flex align-items-start mb-3">
                    <i class="bi bi-chat-square-text text-primary me-3 mt-1"></i>
                    <span class="text-muted">Pilihan anonimitas untuk merahasiakan identitas</span>
                  </li> --}}

                </ul>
              </div>
              <div class="col-12 col-lg-6">
                <div class="card border-0 shadow-lg">
                  <div class="card-body p-5 text-center">
                    <h4 class="h3 fw-semibold text-dark mb-4">Kemudahan Akses</h4>
                    <p class="text-muted mb-4">
                      SIADU dapat diakses 24/7 melalui berbagai perangkat dengan desain responsif yang user-friendly
                    </p>
                    <div class="row g-3">
                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <div
                          class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                          style="width: 60px; height: 60px;">
                          <i class="bi bi-laptop fs-3 text-primary"></i>
                        </div>
                        <small class="text-muted">Desktop</small>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <div
                          class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                          style="width: 60px; height: 60px;">
                          <i class="bi bi-phone fs-3 text-primary"></i>
                        </div>
                        <small class="text-muted">Mobile</small>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-4">
                        <div
                          class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                          style="width: 60px; height: 60px;">
                          <i class="bi bi-envelope fs-3 text-primary"></i>
                        </div>
                        <small class="text-muted">Email</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- statistic section -->
  <section class="py-5 bg-primary text-white">
    <div class="container py-5">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <h2 class="display-4 fw-bold mb-4">SIADU dalam Angka</h2>
          <p class="lead fs-4 text-primary-emphasis mx-auto">
            Sistem yang dirancang untuk memberikan pelayanan terbaik bagi masyarakat
          </p>
        </div>
      </div>

      <div class="row g-4 mb-5">

        <div class="col-12 col-md-6 col-lg-3">
          <div class="card bg-white bg-opacity-10 border-white border-opacity-25 text-white">
            <div class="card-body p-4 text-center">
              <div class="display-3 fw-bold mb-2">3</div>
              <div class="h5 fw-semibold text-primary-emphasis mb-1">Jenis Pengguna</div>
              <div class="small text-primary-emphasis">User, Petugas, Admin</div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card bg-white bg-opacity-10 border-white border-opacity-25 text-white">
            <div class="card-body p-4 text-center">
              <div class="display-3 fw-bold mb-2">6+</div>
              <div class="h5 fw-semibold text-primary-emphasis mb-1">Fitur Utama</div>
              <div class="small text-primary-emphasis">Lengkap & Terintegrasi</div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card bg-white bg-opacity-10 border-white border-opacity-25 text-white">
            <div class="card-body p-4 text-center">
              <div class="display-3 fw-bold mb-2">24/7</div>
              <div class="h5 fw-semibold text-primary-emphasis mb-1">Layanan Online</div>
              <div class="small text-primary-emphasis">Akses Kapan Saja</div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-lg-3">
          <div class="card bg-white bg-opacity-10 border-white border-opacity-25 text-white">
            <div class="card-body p-4 text-center">
              <div class="display-3 fw-bold mb-2">100%</div>
              <div class="h5 fw-semibold text-primary-emphasis mb-1">Transparansi</div>
              <div class="small text-primary-emphasis">Proses Terbuka</div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-12">
          <div class="bg-white bg-opacity-10 rounded p-5">
            <h3 class="h2 fw-bold text-center mb-5">Manfaat untuk Masyarakat</h3>
            <div class="row g-4 text-center">
              <div class="col-12 col-md-4">
                <div class="mb-3" style="font-size: 3rem;">
                  🚀
                </div>
                <h4 class="fw-semibold mb-2">Proses Lebih Cepat</h4>
                <p class="text-primary-emphasis small">Penanganan aduan yang lebih efisien</p>
              </div>
              <div class="col-12 col-md-4">
                <div class="mb-3" style="font-size: 3rem;">
                  🔍
                </div>
                <h4 class="fw-semibold mb-2">Transparansi Penuh</h4>
                <p class="text-primary-emphasis small">Tracking status real-time</p>
              </div>
              <div class="col-12 col-md-4">
                <div class="mb-3" style="font-size: 3rem;">
                  🤝
                </div>
                <h4 class="fw-semibold mb-2">Komunikasi 2 Arah</h4>
                <p class="text-primary-emphasis small">Dialog langsung dengan instansi</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- team section -->
  <section class="py-5 bg-light">
    <div class="container py-5">
      <div class="row">
        <div class="col-12 text-center mb-5">
          <h2 class="display-4 fw-bold text-dark mb-4">Tim Pengembang</h2>
          <p class="lead fs-4 text-muted mx-auto">
            Kelompok 23 - Mahasiswa Fakultas Teknik dan Informatika
            <br />
            Universitas Bina Sarana Informatika Jakarta
          </p>
        </div>
      </div>

      <div class="row g-4 mb-5">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">TA</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Trisna Almuti</h6>
              <p class="card-text small text-muted mb-1">NIM: 17231043</p>
              <p class="card-text small text-primary">17.4A.26</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">DA</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Daffa Aditia R</h6>
              <p class="card-text small text-muted mb-1">NIM: 17230437</p>
              <p class="card-text small text-primary">17.4A.26</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">MR</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Muhammad Rifqi M</h6>
              <p class="card-text small text-muted mb-1">NIM: 17230072</p>
              <p class="card-text small text-primary">17.4A.04</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">MD</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Muhammad David</h6>
              <p class="card-text small text-muted mb-1">NIM: 17231011</p>
              <p class="card-text small text-primary">17.4A.26</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">AK</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Aidil Koto</h6>
              <p class="card-text small text-muted mb-1">NIM: 19231441</p>
              <p class="card-text small text-primary">19.4A.37</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">HS</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Haikal Siregar</h6>
              <p class="card-text small text-muted mb-1">NIM: 19230871</p>
              <p class="card-text small text-primary">19.4A.37</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">CT</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Cholil Tamami</h6>
              <p class="card-text small text-muted mb-1">NIM: 19231720</p>
              <p class="card-text small text-primary">19.4B.37</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">FN</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Firman Nasty Aulia</h6>
              <p class="card-text small text-muted mb-1">NIM: 19232231</p>
              <p class="card-text small text-primary">19.4B.37</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">MR</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Muhammad Rafi</h6>
              <p class="card-text small text-muted mb-1">NIM: 19232181</p>
              <p class="card-text small text-primary">19.4B.37</p>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
          <div class="card h-100 border-0 shadow">
            <div class="card-body p-4 text-center">
              <div
                class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                __v0_r="0,1624,1727" style="width: 60px; height: 60px;"><span class="text-primary fw-bold"
                  __v0_r="0,1846,1868">AF</span></div>
              <h6 class="card-title fw-semibold text-dark mb-2">Adani Febriyan</h6>
              <p class="card-text small text-muted mb-1">NIM: 19232301</p>
              <p class="card-text small text-primary">19.4B.37</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card border-0 shadow-lg">
            <div class="card-body p-5 text-center">
              <h3 class="h2 fw-bold text-dark mb-4">Proyek IT Bootcamp</h3>
              <p class="text-muted mb-5">
                SIADU dikembangkan sebagai bukti laporan hasil kegiatan IT Bootcamp Semester Genap T.A. 2025/2026 di
                Fakultas Teknik dan Informatika, Universitas Bina Sarana Informatika Jakarta.
              </p>
              <div class="row g-4">
                <div class="col-12 col-md-4">
                  <div class="h2 fw-bold text-primary">2025</div>
                  <div class="small text-muted">Tahun Pengembangan</div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="h2 fw-bold text-primary">10</div>
                  <div class="small text-muted">Anggota Tim</div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="h2 fw-bold text-primary">UBSI</div>
                  <div class="small text-muted">Universitas</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer section -->
  <footer class="bg-dark text-white">
    <div class="container py-5">
      <div class="row g-4">
        <div class="col-12 col-lg-6">
          <h3 class="h2 fw-bold mb-4">SIADU</h3>
          <p class="text-light mb-4">
            Sistem Informasi Aduan Masyarakat - Platform digital untuk mempermudah masyarakat dalam menyampaikan aduan
            kepada instansi terkait dengan proses yang transparan dan akuntabel.
          </p>
          <div class="d-flex gap-3">
            <button class="btn btn-primary" onclick="window.location='{{ route('backend.login') }}'">
              <i class="bi bi-play-circle me-2"></i>
              Mulai Lapor
            </button>
            {{-- <button class="btn btn-outline-light">
              <i class="bi bi-search me-2"></i>
              Cek Status Aduan
            </button> --}}
          </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
          <h4 class="h5 fw-semibold mb-4">Fitur Utama</h4>
          <ul class="list-unstyled text-light">
            <li class="mb-2">
              <i class="bi bi-check me-2"></i>
              Form Aduan Online
            </li>
            <li class="mb-2">
              <i class="bi bi-check me-2"></i>
              Dashboard Pengguna
            </li>
            <li class="mb-2">
              <i class="bi bi-check me-2"></i>
              Notifikasi Real-time
            </li>
            <li class="mb-2">
              <i class="bi bi-check me-2"></i>
              Statistik & Laporan
            </li>
            <li class="mb-2">
              <i class="bi bi-check me-2"></i>
              Multi-level Access
            </li>
          </ul>
        </div>

        <div class="col-12 col-md-6 col-lg-3">
          <h4 class="h5 fw-semibold mb-4">Kontak</h4>
          <div class="text-light">
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-envelope me-2"></i>
              <small>19231720@bsi.ac.id</small>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-telephone me-2"></i>
              <small>+62 882-2287-7992</small>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-geo-alt me-2"></i>
              <small>Jakarta, Indonesia</small>
            </div>
            <div class="d-flex align-items-center mb-2">
              <i class="bi bi-globe me-2"></i>
              <small>ubsi.ac.id</small>
            </div>
          </div>
        </div>
      </div>

      <hr class="border-secondary my-4" />

      <div class="row align-items-center">
        <div class="col-12 col-md-8">
          <small class="text-muted">
            © 2025 SIADU - Kelompok 23. Universitas Bina Sarana Informatika. All rights reserved.
          </small>
        </div>
        <div class="col-12 col-md-4 text-md-end mt-3 mt-md-0">
          <div class="d-flex gap-3 justify-content-md-end">
            <a href="#" class="text-muted text-decoration-none small hover-text-white">
              Privacy Policy
            </a>
            <a href="#" class="text-muted text-decoration-none small hover-text-white">
              Terms of Service
            </a>
            <a href="#" class="text-muted text-decoration-none small hover-text-white">
              Support
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script>
       function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
            }
        }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
