<section id="home" class="home-section">
    <div class="slider">
        <div class="slides">
            <div class="slide active">
                <img src="asset/img/bengkel_motor.jpg" alt="Banner 1">
                <div class="slide-text">
                    <h2>Bengkel Motor & Mobil Terpercaya</h2>
                    <p>Pelayanan cepat, mekanik profesional, dan harga terjangkau.</p>
                    <a href="pages/reservasi/reservasi.php" class="btn btn-primary">Reservasi Sekarang</a>
                </div>
            </div>
            <div class="slide">
                <img src="asset/img/servis.jpg" alt="Banner 2">
                <div class="slide-text">
                    <h2>Perawatan Kendaraan Lengkap</h2>
                    <p>Servis rutin, ganti oli, perbaikan mesin, dan banyak lagi.</p>
                    <a href="#layanan" class="btn btn-primary">Lihat Layanan</a>
                </div>
            </div>
            <div class="slide">
                <img src="asset/img/mekanik.jpg" alt="Banner 3">
                <div class="slide-text">
                    <h2>Mekanik Profesional & Berpengalaman</h2>
                    <p>Kami menjamin kualitas servis dan kepuasan pelanggan.</p>
                    <a href="#mekanik" class="btn btn-primary">Temui Mekanik</a>
                </div>
            </div>
        </div>

        <div class="slider-nav">
            <span class="prev">&#10094;</span>
            <span class="next">&#10095;</span>
        </div>
    </div>
</section>

<style>
    /* 🛠️ RESET CSS & FULLEST SCREEN HEIGHT (DENGAN MARGIN MEFET 5PX) */
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .home-section {
        position: relative;
        width: 100%;
        /* Jarak mepet 5px di atas */
        margin-top: 5px;
        /* Mengisi sisa tinggi layar agar tidak ada scrollbar */
        height: calc(100vh - 5px);
        overflow: hidden;
    }

    .slider {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
        height: 100%;
    }

    .slide {
        min-width: 100%;
        height: 100%;
        position: relative;
        display: none;
    }

    .slide.active {
        display: block;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ⬆️ MODIFIKASI INTI: Membuat Card Teks Lebih Tinggi ⬆️ */
    .slide-text {
        position: absolute;
        top: 50%;
        left: 10%;
        transform: translateY(-50%);
        color: white;
        /* NILAI PENTING: Tingkatkan padding vertikal (atas/bawah) */
        padding: 50px 40px;

        /* Background untuk memperjelas batas card */
        background-color: rgba(0, 0, 0, 0.4);
        border-radius: 5px;
        text-shadow: none;
    }

    .slide-text h2 {
        font-size: 48px;
        margin-bottom: 15px;
        color: #ff0000;
    }

    .slide-text p {
        font-size: 18px;
        margin-bottom: 20px;
        color: #ffffff;
    }

    .slide-text .btn {
        padding: 10px 25px;
        background-color: #ff0000;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    }

    .slide-text .btn:hover {
        background-color: #cc0000;
    }

    .slider-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        padding: 0 20px;
        pointer-events: none;
    }

    .slider-nav span {
        font-size: 36px;
        color: #ffffff;
        background-color: rgba(255, 0, 0, 0.6);
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
        pointer-events: all;
        user-select: none;
    }
</style>

<script>
    // Slider JavaScript (Tidak ada perubahan)
    let slides = document.querySelectorAll('.slide');
    let current = 0;
    let nextBtn = document.querySelector('.next');
    let prevBtn = document.querySelector('.prev');

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) slide.classList.add('active');
        });
    }

    nextBtn.addEventListener('click', () => {
        current = (current + 1) % slides.length;
        showSlide(current);
    });

    prevBtn.addEventListener('click', () => {
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
    });

    // Auto slide every 5 seconds
    setInterval(() => {
        current = (current + 1) % slides.length;
        showSlide(current);
    }, 5000);

    // Initialize
    showSlide(current);
</script>