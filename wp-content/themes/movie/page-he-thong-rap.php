<?php
/**
 * Template Name: Hệ Thống Rạp
 */
get_header(); 
?>

<div class="container" style="padding: 40px 20px;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #fff; text-transform: uppercase;">Hệ Thống Rạp Riot</h1>
    
    <div class="cinema-system-grid">
        <?php
        $args = array(
            'post_type' => 'mbs_cinema',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC'
        );
        
        $cinemas = new WP_Query($args);
        
        if ($cinemas->have_posts()) :
            while ($cinemas->have_posts()) : $cinemas->the_post();
                $address = get_post_meta(get_the_ID(), '_mbs_address', true);
                $phone = get_post_meta(get_the_ID(), '_mbs_phone', true);
                $thumb_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                if (!$thumb_url) {
                    $thumb_url = 'https://via.placeholder.com/600x400/1a1a2e/ffffff?text=' . urlencode(get_the_title());
                }
        ?>
                <div class="cinema-card">
                    <div class="cinema-thumb">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?php echo esc_url($thumb_url); ?>" alt="<?php the_title_attribute(); ?>">
                        </a>
                    </div>
                    <div class="cinema-info">
                        <h3 class="cinema-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <?php if ($address): ?>
                            <p class="cinema-address"><i class='bx bxs-map'></i> <?php echo esc_html($address); ?></p>
                        <?php endif; ?>
                        <?php if ($phone): ?>
                            <p class="cinema-phone"><i class='bx bxs-phone'></i> <?php echo esc_html($phone); ?></p>
                        <?php endif; ?>
                        
                        <div class="cinema-actions">
                            <a href="<?php the_permalink(); ?>" class="btn-detail">Xem chi tiết</a>
                            <a href="<?php echo home_url('/datve?cinema=' . get_the_ID()); ?>" class="btn-booking">Đặt vé ngay</a>
                        </div>
                    </div>
                </div>
        <?php
            endwhile;
            wp_reset_postdata();
        else:
        ?>
            <p style="color: #fff; text-align: center; grid-column: 1 / -1;">Hiện chưa có rạp nào trong hệ thống.</p>
        <?php endif; ?>
    </div>
</div>

<style>
    .cinema-system-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 30px;
    }
    
    .cinema-card {
        background: #1a1a2e; /* Dark blue background */
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .cinema-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(255, 228, 77, 0.15);
        border-color: rgba(255, 228, 77, 0.3);
    }
    
    .cinema-thumb {
        height: 200px;
        overflow: hidden;
    }
    
    .cinema-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .cinema-card:hover .cinema-thumb img {
        transform: scale(1.05);
    }
    
    .cinema-info {
        padding: 20px;
    }
    
    .cinema-title {
        margin: 0 0 10px;
        font-size: 20px;
        font-weight: 700;
        text-transform: uppercase;
    }
    
    .cinema-title a {
        color: #fff;
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .cinema-title a:hover {
        color: #ffe44d;
    }
    
    .cinema-address, .cinema-phone {
        color: #cbd5e1;
        font-size: 14px;
        margin-bottom: 8px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    
    .cinema-address i, .cinema-phone i {
        color: #ffe44d;
        margin-top: 3px;
    }
    
    .cinema-actions {
        margin-top: 20px;
        display: flex;
        gap: 10px;
    }
    
    .btn-detail, .btn-booking {
        flex: 1;
        text-align: center;
        padding: 10px;
        border-radius: 6px;
        font-weight: 600;
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s;
        text-transform: uppercase;
    }
    
    .btn-detail {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    
    .btn-detail:hover {
        background: rgba(255, 255, 255, 0.2);
    }
    
    .btn-booking {
        background: #ffe44d;
        color: #000;
    }
    
    .btn-booking:hover {
        background: #e6cd43;
    }
    
    @media (max-width: 768px) {
        .cinema-system-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php get_footer(); ?>
