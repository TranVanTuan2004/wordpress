<!-- Hero Banner - Movie Booking -->
<section class="hero-banner">
    <div class="hero-container">
        <div class="hero-content">
            <h1 class="hero-title">
                Mua vé xem phim Online trên <span class="brand-name">CinemaHub</span>
            </h1>
            
            <p class="hero-description">
                Với nhiều ưu đãi hấp dẫn và kết nối với tất cả các rạp lớn phủ rộng khắp Việt Nam. 
                Đặt vé ngay tại CinemaHub!
            </p>
            
            <ul class="hero-features">
                <li>
                    <svg class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Mua vé Online, <strong>trải nghiệm phim hay</strong></span>
                </li>
                <li>
                    <svg class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span><strong>Đặt vé an toàn</strong> trên CinemaHub</span>
                </li>
                <li>
                    <svg class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span>Tìm hồ <strong>chọn chỗ ngồi, mua bắp nước</strong> tiện lợi.</span>
                </li>
                <li>
                    <svg class="check-icon" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span><strong>Lịch sử đặt vé</strong> được lưu lại ngay</span>
                </li>
            </ul>
            
            <a href="<?php echo home_url('/movies'); ?>" class="hero-button">
                ĐẶT VÉ NGAY
            </a>
        </div>
        
        <div class="hero-image">
            <div class="promo-card">
                <h2 class="promo-title">Đặt vé xem phim trên CinemaHub</h2>
                <p class="promo-subtitle">Ghế đẹp, giá hời, vào rạp</p>
                <p class="promo-highlight">không chờ đợi</p>
                
                <div class="promo-illustration">
                    <!-- Decorative elements -->
                    <div class="deco-circle deco-1"></div>
                    <div class="deco-circle deco-2"></div>
                    <div class="deco-circle deco-3"></div>
                    <div class="deco-circle deco-4"></div>
                    <div class="deco-circle deco-5"></div>
                    <div class="deco-circle deco-6"></div>
                    
                    <!-- Movie ticket icon -->
                    <div class="ticket-icon">
                        <svg viewBox="0 0 200 150" fill="none">
                            <rect x="20" y="30" width="160" height="90" rx="8" fill="#FF6B9D" opacity="0.9"/>
                            <rect x="30" y="40" width="140" height="70" rx="4" fill="#FFF" opacity="0.3"/>
                            <circle cx="50" cy="50" r="8" fill="#FFF" opacity="0.5"/>
                            <circle cx="50" cy="75" r="8" fill="#FFF" opacity="0.5"/>
                            <circle cx="50" cy="100" r="8" fill="#FFF" opacity="0.5"/>
                            <rect x="70" y="45" width="100" height="6" rx="3" fill="#FFF" opacity="0.7"/>
                            <rect x="70" y="60" width="80" height="6" rx="3" fill="#FFF" opacity="0.7"/>
                            <rect x="70" y="75" width="90" height="6" rx="3" fill="#FFF" opacity="0.7"/>
                        </svg>
                    </div>
                    
                    <!-- People illustration -->
                    <div class="people-illustration">
                        <div class="person person-1">
                            <div class="head"></div>
                            <div class="body"></div>
                            <div class="arm arm-left"></div>
                            <div class="arm arm-right"></div>
                        </div>
                        <div class="person person-2">
                            <div class="head"></div>
                            <div class="body"></div>
                            <div class="arm arm-left"></div>
                            <div class="arm arm-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.hero-banner {
    background: linear-gradient(135deg, #FFE5F0 0%, #FFF0F5 50%, #FFF8DC 100%);
    padding: 80px 20px;
    overflow: hidden;
}

.hero-container {
    max-width: 1400px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.hero-content {
    padding: 0 20px;
}

.hero-title {
    font-size: 48px;
    font-weight: 700;
    color: #2D3748;
    line-height: 1.2;
    margin-bottom: 20px;
}

.brand-name {
    color: #E91E63;
}

.hero-description {
    font-size: 18px;
    color: #4A5568;
    line-height: 1.6;
    margin-bottom: 30px;
}

.hero-features {
    list-style: none;
    margin-bottom: 40px;
}

.hero-features li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
    color: #2D3748;
    font-size: 16px;
}

.check-icon {
    width: 24px;
    height: 24px;
    color: #E91E63;
    flex-shrink: 0;
    margin-top: 2px;
}

.hero-features strong {
    color: #E91E63;
    font-weight: 600;
}

.hero-button {
    display: inline-block;
    background: linear-gradient(135deg, #E91E63 0%, #D81B60 100%);
    color: white;
    padding: 18px 45px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: 700;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 8px 20px rgba(233, 30, 99, 0.3);
    transition: all 0.3s ease;
}

.hero-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(233, 30, 99, 0.4);
}

.hero-image {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

.promo-card {
    background: linear-gradient(135deg, #FFF9E5 0%, #FFEDD5 100%);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
    max-width: 500px;
}

.promo-title {
    font-size: 28px;
    font-weight: 700;
    color: #2D3748;
    margin-bottom: 10px;
    line-height: 1.3;
}

.promo-subtitle {
    font-size: 22px;
    color: #4A5568;
    font-weight: 600;
    margin-bottom: 5px;
}

.promo-highlight {
    font-size: 32px;
    font-weight: 800;
    color: #E91E63;
    font-style: italic;
    margin-bottom: 30px;
    text-decoration: underline wavy;
    text-decoration-color: #FF6B9D;
}

.promo-illustration {
    position: relative;
    height: 300px;
    margin-top: 20px;
}

/* Decorative circles */
.deco-circle {
    position: absolute;
    border-radius: 50%;
    background: #FFB6C1;
    opacity: 0.3;
}

.deco-1 { width: 60px; height: 60px; top: 20px; left: 10px; }
.deco-2 { width: 40px; height: 40px; top: 50px; left: 80px; }
.deco-3 { width: 50px; height: 50px; top: 100px; left: 30px; }
.deco-4 { width: 45px; height: 45px; top: 150px; right: 100px; background: #FFDAB9; }
.deco-5 { width: 55px; height: 55px; top: 30px; right: 40px; background: #FFE4B5; }
.deco-6 { width: 35px; height: 35px; bottom: 40px; right: 20px; background: #FFB6C1; }

/* Ticket icon */
.ticket-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-5deg);
    width: 200px;
    height: 150px;
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translate(-50%, -50%) rotate(-5deg) translateY(0); }
    50% { transform: translate(-50%, -50%) rotate(-5deg) translateY(-10px); }
}

/* People illustration */
.people-illustration {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 20px;
}

.person {
    position: relative;
}

.person .head {
    width: 50px;
    height: 50px;
    background: #E91E63;
    border-radius: 50%;
    margin-bottom: 5px;
}

.person .body {
    width: 60px;
    height: 80px;
    background: #FF6B9D;
    border-radius: 20px 20px 30px 30px;
}

.person .arm {
    position: absolute;
    width: 20px;
    height: 60px;
    background: #FF6B9D;
    border-radius: 10px;
}

.person .arm-left {
    top: 55px;
    left: -10px;
    transform: rotate(-20deg);
}

.person .arm-right {
    top: 55px;
    right: -10px;
    transform: rotate(20deg);
}

.person-1 {
    animation: wave 2s ease-in-out infinite;
}

.person-2 {
    animation: wave 2s ease-in-out infinite 0.5s;
}

@keyframes wave {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

/* Responsive */
@media (max-width: 968px) {
    .hero-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    .hero-title {
        font-size: 36px;
    }
    
    .promo-card {
        max-width: 100%;
    }
}

@media (max-width: 640px) {
    .hero-banner {
        padding: 40px 15px;
    }
    
    .hero-title {
        font-size: 28px;
    }
    
    .hero-description {
        font-size: 16px;
    }
    
    .hero-features li {
        font-size: 14px;
    }
    
    .promo-title {
        font-size: 22px;
    }
    
    .promo-subtitle {
        font-size: 18px;
    }
    
    .promo-highlight {
        font-size: 24px;
    }
}
</style>

