<?php
/**
 * Template Name: Tuyển Dụng
 */
get_header(); 
?>

<div class="recruitment-page">
    <!-- Header Section -->
    <div class="recruitment-header">
        <div class="container">
            <h1>RIOT TUYỂN DỤNG</h1>
            <p>Chúng tôi tin rằng con người là yếu tố cốt lõi tạo nên thành công - vì vậy, Cinestar luôn tìm kiếm những gương mặt trẻ trung, nhiệt huyết và giàu tinh thần trách nhiệm để cùng nhau kiến tạo môi trường làm việc tích cực, sáng tạo và chuyên nghiệp.</p>
        </div>
    </div>

    <!-- Images Section -->
    <div class="recruitment-images">
        <div class="image-item">
            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Office">
        </div>
        <div class="image-item">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Teamwork">
        </div>
        <div class="image-item">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Meeting">
        </div>
    </div>

    <!-- Filter Section -->
    <div class="container">
        <div class="recruitment-filter">
            <select class="filter-select">
                <option value="">Chọn Rạp</option>
                <option value="hcm">TP.HCM</option>
                <option value="hn">Hà Nội</option>
                <option value="hue">Huế</option>
            </select>
        </div>

        <!-- Office Jobs -->
        <div class="recruitment-section">
            <h2 class="section-title">TUYỂN DỤNG KHỐI VĂN PHÒNG</h2>
            <div class="job-list">
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">NHÂN VIÊN KẾ TOÁN CÔNG TRÌNH</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">NHÂN VIÊN KẾ TOÁN</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">TRƯỞNG PHÒNG THU MUA</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cinema Jobs -->
        <div class="recruitment-section">
            <h2 class="section-title">TUYỂN DỤNG KHỐI RẠP PHIM</h2>
            <div class="job-list">
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">TUYỂN DỤNG NHÂN VIÊN PHỤC VỤ KHÁCH HÀNG</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">CINESTAR SATRA QUẬN 6 - TUYỂN DỤNG</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">CINESTAR KIÊN GIANG - TUYỂN DỤNG</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
                <!-- Job Item -->
                <div class="job-item">
                    <div class="job-info">
                        <h3 class="job-title">RIOT PARKCITY HÀ NỘI TUYỂN DỤNG</h3>
                        <span class="job-status">Tình trạng: <span class="status-active">Đang tuyển</span></span>
                    </div>
                    <div class="job-actions">
                        <a href="#" class="btn-apply">ỨNG TUYỂN</a>
                        <a href="#" class="btn-detail">XEM CHI TIẾT</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .recruitment-page {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
        min-height: 100vh;
        color: #fff;
        padding-bottom: 60px;
        font-family: 'Arial', sans-serif;
    }

    .recruitment-header {
        background: #0b1221;
        padding: 40px 0;
        text-align: center;
    }

    .recruitment-header h1 {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        margin: 0 0 20px;
        color: #fff;
    }

    .recruitment-header p {
        max-width: 800px;
        margin: 0 auto;
        font-size: 14px;
        line-height: 1.6;
        color: #cbd5e1;
    }

    .recruitment-images {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        margin-bottom: 40px;
    }

    .image-item {
        height: 250px;
        overflow: hidden;
    }

    .image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .image-item:hover img {
        transform: scale(1.1);
    }

    .recruitment-filter {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 40px;
    }

    .filter-select {
        background: #1e293b;
        color: #ffe44d;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 700;
        cursor: pointer;
    }

    .recruitment-section {
        margin-bottom: 60px;
    }

    .section-title {
        text-align: center;
        font-size: 24px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 30px;
        color: #fff;
    }

    .job-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .job-item {
        background: rgba(59, 130, 246, 0.15); /* Blue tint background */
        border: 1px solid rgba(59, 130, 246, 0.3);
        padding: 20px;
        border-radius: 4px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.3s;
    }

    .job-item:hover {
        background: rgba(59, 130, 246, 0.25);
    }

    .job-info h3 {
        margin: 0 0 8px;
        font-size: 18px;
        font-weight: 800;
        text-transform: uppercase;
        color: #fff;
    }

    .job-status {
        font-size: 13px;
        color: #cbd5e1;
    }

    .status-active {
        color: #ffe44d;
        font-weight: 700;
        font-style: italic;
    }

    .job-actions {
        display: flex;
        gap: 10px;
    }

    .btn-apply, .btn-detail {
        padding: 8px 20px;
        border-radius: 4px;
        font-weight: 700;
        text-decoration: none;
        font-size: 12px;
        text-transform: uppercase;
        transition: all 0.3s;
    }

    .btn-apply {
        background: #ffe44d;
        color: #000;
        border: 1px solid #ffe44d;
    }

    .btn-apply:hover {
        background: #eab308;
        border-color: #eab308;
    }

    .btn-detail {
        background: transparent;
        color: #ffe44d;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-detail:hover {
        border-color: #ffe44d;
    }

    @media (max-width: 768px) {
        .recruitment-images {
            grid-template-columns: 1fr;
        }
        .job-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        .job-actions {
            width: 100%;
        }
        .btn-apply, .btn-detail {
            flex: 1;
            text-align: center;
        }
    }

    /* Modal CSS */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.open {
        display: flex;
        opacity: 1;
    }

    .modal-content {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 27, 75, 0.95) 100%);
        width: 90%;
        max-width: 450px;
        max-height: 600px;
        border-radius: 16px;
        padding: 30px;
        position: relative;
        transform: translateY(-20px);
        transition: transform 0.3s ease;
        overflow-y: auto;
        /* Hide scrollbar for Chrome, Safari and Opera */
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        color: #fff;
    }

    .modal-content::-webkit-scrollbar {
        display: none;
    }

    .modal-overlay.open .modal-content {
        transform: translateY(0);
    }

    .modal-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        cursor: pointer;
        transition: all 0.3s;
    }

    .modal-close:hover {
        background: #ef4444;
        transform: rotate(90deg);
    }

    .modal-title {
        font-size: 24px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
        background: linear-gradient(to right, #ffe44d, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
    }

    /* Contact Form 7 Styles inside Modal */
    .modal-body .wpcf7-form-control-wrap {
        display: block;
        margin-bottom: 20px;
    }

    .modal-body input[type="text"],
    .modal-body input[type="email"],
    .modal-body input[type="tel"],
    .modal-body textarea {
        width: 100%;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: #fff;
        font-size: 15px;
        transition: all 0.3s;
        outline: none;
    }

    .modal-body input:focus,
    .modal-body textarea:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ffe44d;
        box-shadow: 0 0 0 2px rgba(255, 228, 77, 0.2);
    }

    .modal-body input::placeholder,
    .modal-body textarea::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .modal-body input[type="submit"] {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #ffe44d 0%, #ffd700 100%);
        color: #000;
        font-weight: 800;
        text-transform: uppercase;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .modal-body input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 215, 0, 0.2);
    }

    .modal-body label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #cbd5e1;
    }

    /* CF7 Response Messages */
    .modal-body .wpcf7-response-output {
        border-radius: 8px;
        padding: 15px !important;
        margin: 20px 0 !important;
        text-align: center;
        font-weight: 600;
        font-size: 15px;
    }

    .modal-body .wpcf7-not-valid-tip {
        color: #ef4444;
        font-size: 13px;
        margin-top: 5px;
    }

    /* Success */
    .modal-body form.sent .wpcf7-response-output {
        background: rgba(16, 185, 129, 0.2);
        border: 1px solid #10b981 !important;
        color: #10b981;
    }

    /* Error */
    .modal-body form.invalid .wpcf7-response-output,
    .modal-body form.failed .wpcf7-response-output {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid #ef4444 !important;
        color: #ef4444;
    }
</style>

<!-- Recruitment Modal -->
<div class="modal-overlay" id="recruitmentModal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h3 class="modal-title">ỨNG TUYỂN NGAY</h3>
        <div class="modal-body">
            <?php echo do_shortcode('[contact-form-7 id="871834f" title="Tuyển dụng"]'); ?>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('recruitmentModal');
    const applyBtns = document.querySelectorAll('.btn-apply');

    applyBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            openModal();
        });
    });

    function openModal() {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = ''; // Restore scrolling
    }

    // Close when clicking outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>

<?php get_footer(); ?>
