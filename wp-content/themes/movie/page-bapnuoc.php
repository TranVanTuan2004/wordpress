<?php
/**
 * Template Name: Trang Đặt Bắp Nước
 */
get_header();

// Fetch Cinemas
$cinemas = get_posts(array(
  'post_type'      => 'mbs_cinema',
  'posts_per_page' => -1,
  'orderby'        => 'title',
  'order'          => 'ASC',
));
?>

<main class="bn-page">
  <div class="bn-container">
    <h1 class="bn-title">Đặt Bắp Nước</h1>

    <!-- Step 1: Select Cinema -->
    <div id="bn-step-1" class="bn-step-container">
      <div class="bn-cinema-selector">
        <h2 class="bn-step-title">Bạn muốn nhận bắp nước tại rạp nào?</h2>
        <p class="bn-step-desc">Vui lòng chọn rạp để xem menu phù hợp</p>
        
        <div class="bn-cinema-grid">
            <?php if ($cinemas): ?>
                <?php foreach ($cinemas as $cinema): ?>
                    <button class="bn-cinema-btn" onclick="selectCinema(<?php echo $cinema->ID; ?>, '<?php echo esc_js($cinema->post_title); ?>')">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo esc_html($cinema->post_title); ?></span>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="bn-empty">Hiện chưa có rạp nào hoạt động.</p>
            <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Step 2: Select Products (Hidden initially) -->
    <div id="bn-step-2" class="bn-layout" style="display: none;">
      <!-- Product List -->
      <section class="bn-products">
        <div class="bn-selected-cinema-bar">
            <span>Đang đặt tại: <strong id="bn-current-cinema-name">...</strong></span>
            <button class="bn-change-cinema-btn" onclick="changeCinema()">Đổi rạp</button>
        </div>

        <?php
        // Fetch WooCommerce Products
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
            'orderby' => 'menu_order title',
            'order' => 'ASC',
            'post_status' => 'publish',
        );
        $loop = new WP_Query($args);
        ?>
        
        <div class="bn-grid">
          <?php if ($loop->have_posts()): ?>
            <?php while ($loop->have_posts()): $loop->the_post(); global $product; ?>
                <?php 
                    // Skip ticket products
                    if (strpos($product->get_sku(), 'ticket-movie-') === 0 || $product->get_name() === 'Vé xem phim') {
                        continue;
                    }

                    $img_url = get_the_post_thumbnail_url($loop->post->ID, 'large'); 
                    if (!$img_url) $img_url = wc_placeholder_img_src();
                    if (!$img_url) $img_url = 'https://placehold.co/400x400?text=No+Image';
                ?>
                <div class="bn-item">
                  <div class="bn-img">
                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php the_title(); ?>">
                  </div>
                  <div class="bn-info">
                    <h3 class="bn-name"><?php the_title(); ?></h3>
                    <p class="bn-desc"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                    <div class="bn-price"><?php echo $product->get_price_html(); ?></div>
                    <div class="bn-action">
                      <button class="bn-btn-qty minus" onclick="updateQty(<?php echo $product->get_id(); ?>, -1)">-</button>
                      <span class="bn-qty" id="qty-<?php echo $product->get_id(); ?>" data-price="<?php echo esc_attr($product->get_price()); ?>" data-name="<?php echo esc_attr($product->get_name()); ?>">0</span>
                      <button class="bn-btn-qty plus" onclick="updateQty(<?php echo $product->get_id(); ?>, 1)">+</button>
                    </div>
                  </div>
                </div>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
          <?php else: ?>
            <p class="bn-empty" style="grid-column: 1/-1;">Chưa có sản phẩm nào. Vui lòng thêm sản phẩm trong trang quản trị.</p>
          <?php endif; ?>
        </div>
      </section>

      <!-- Sidebar Cart -->
      <aside class="bn-sidebar">
        <div class="bn-cart">
          <h2 class="bn-subtitle">Giỏ hàng</h2>
          <div id="bn-cart-items" class="bn-cart-items">
            <p class="bn-empty">Chưa có sản phẩm nào</p>
          </div>
          <div class="bn-summary">
            <div class="bn-row">
              <span>Tổng cộng:</span>
              <strong id="bn-total">0đ</strong>
            </div>
          </div>
          <button class="bn-checkout-btn" id="btn-checkout" onclick="checkout()">Thanh toán ngay</button>
        </div>
      </aside>
    </div>
  </div>

  <style>
    .bn-page { color: #e5e7eb; min-height: 100vh; background-color: #0f172a; }
    .bn-container { max-width: 1200px; margin: 0 auto; padding: 40px 16px; }
    .bn-title { margin: 0 0 24px; font-size: 32px; font-weight: 800; color: #fff; text-transform: uppercase; letter-spacing: 1px; text-align: center; }
    
    /* Step 1 Styles */
    .bn-step-container { max-width: 800px; margin: 0 auto; background: #1e293b; padding: 40px; border-radius: 16px; border: 1px solid rgba(148,163,184,0.1); text-align: center; }
    .bn-step-title { font-size: 24px; color: #fff; margin-bottom: 10px; }
    .bn-step-desc { color: #94a3b8; margin-bottom: 30px; }
    .bn-cinema-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
    .bn-cinema-btn { 
        background: #0f172a; border: 1px solid rgba(148,163,184,0.2); color: #e2e8f0; 
        padding: 20px; border-radius: 12px; cursor: pointer; transition: all 0.2s;
        display: flex; flex-direction: column; align-items: center; gap: 10px; font-size: 16px; font-weight: 600;
    }
    .bn-cinema-btn i { font-size: 24px; color: #ffe44d; }
    .bn-cinema-btn:hover { background: #334155; border-color: #ffe44d; transform: translateY(-2px); }
    
    /* Step 2 Styles */
    .bn-layout { display: grid; grid-template-columns: 1fr 350px; gap: 30px; animation: fadeIn 0.5s ease; }
    .bn-selected-cinema-bar { 
        background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.3); 
        padding: 12px 20px; border-radius: 8px; margin-bottom: 24px; 
        display: flex; justify-content: space-between; align-items: center; color: #c7d2fe;
    }
    .bn-selected-cinema-bar strong { color: #fff; }
    .bn-change-cinema-btn { background: transparent; border: 1px solid #c7d2fe; color: #c7d2fe; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 12px; transition: all 0.2s; }
    .bn-change-cinema-btn:hover { background: #c7d2fe; color: #1e293b; }

    .bn-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
    .bn-item { background: #1e293b; border-radius: 12px; overflow: hidden; border: 1px solid rgba(148,163,184,0.1); transition: transform 0.2s; }
    .bn-item:hover { transform: translateY(-4px); border-color: #6366f1; }
    .bn-img { height: 180px; overflow: hidden; background: #000; }
    .bn-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
    .bn-item:hover .bn-img img { transform: scale(1.1); }
    
    .bn-info { padding: 16px; }
    .bn-name { margin: 0 0 4px; font-size: 18px; font-weight: 700; color: #fff; }
    .bn-desc { font-size: 13px; color: #94a3b8; margin-bottom: 12px; height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .bn-price { font-size: 18px; color: #ffe44d; font-weight: 700; margin-bottom: 12px; }
    .bn-price del { color: #64748b; font-size: 14px; margin-right: 5px; }
    .bn-price ins { text-decoration: none; }
    
    .bn-action { display: flex; align-items: center; justify-content: space-between; background: #0f172a; border-radius: 8px; padding: 4px; }
    .bn-btn-qty { width: 32px; height: 32px; border: none; background: #334155; color: #fff; border-radius: 6px; cursor: pointer; font-weight: bold; transition: background 0.2s; }
    .bn-btn-qty:hover { background: #475569; }
    .bn-btn-qty.plus { background: #ffe44d; color: #000; }
    .bn-btn-qty.plus:hover { background: #ffd700; }
    .bn-qty { font-weight: 600; min-width: 30px; text-align: center; }

    .bn-sidebar { position: sticky; top: 20px; }
    .bn-cart { background: #1e293b; border-radius: 12px; padding: 20px; border: 1px solid rgba(148,163,184,0.1); }
    .bn-subtitle { margin: 0 0 16px; font-size: 20px; font-weight: 700; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 12px; }
    
    .bn-cart-items { margin-bottom: 20px; max-height: 400px; overflow-y: auto; }
    .bn-empty { color: #64748b; text-align: center; font-style: italic; padding: 20px 0; }
    .bn-cart-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .bn-cart-item:last-child { border-bottom: none; }
    .bn-ci-info { flex: 1; }
    .bn-ci-name { display: block; font-weight: 600; color: #e2e8f0; font-size: 14px; }
    .bn-ci-meta { font-size: 12px; color: #94a3b8; }
    .bn-ci-total { font-weight: 700; color: #ffe44d; margin-left: 10px; }

    .bn-summary { border-top: 2px dashed rgba(255,255,255,0.1); padding-top: 16px; margin-bottom: 20px; }
    .bn-row { display: flex; justify-content: space-between; font-size: 18px; color: #fff; }
    
    .bn-checkout-btn { width: 100%; height: 48px; background: #ffe44d; color: #000; border: none; border-radius: 8px; font-weight: 800; font-size: 16px; cursor: pointer; text-transform: uppercase; transition: all 0.2s; }
    .bn-checkout-btn:hover { background: #ffd700; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255,228,77,0.3); }
    .bn-checkout-btn:disabled { background: #475569; color: #94a3b8; cursor: not-allowed; transform: none; box-shadow: none; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 900px) {
      .bn-layout { grid-template-columns: 1fr; }
      .bn-sidebar { position: static; }
    }
  </style>

  <script>
    let cart = {};
    let selectedCinemaId = null;

    function selectCinema(id, name) {
        selectedCinemaId = id;
        document.getElementById('bn-current-cinema-name').innerText = name;
        
        // Hide Step 1, Show Step 2
        document.getElementById('bn-step-1').style.display = 'none';
        document.getElementById('bn-step-2').style.display = 'grid';
    }

    function changeCinema() {
        if (Object.keys(cart).length > 0) {
            if (!confirm('Đổi rạp sẽ xóa giỏ hàng hiện tại. Bạn có chắc chắn không?')) {
                return;
            }
            // Clear cart
            cart = {};
            renderCart();
            // Reset qty inputs
            document.querySelectorAll('.bn-qty').forEach(el => el.innerText = '0');
        }
        
        selectedCinemaId = null;
        document.getElementById('bn-step-1').style.display = 'block';
        document.getElementById('bn-step-2').style.display = 'none';
    }

    function updateQty(id, change) {
      const qtyEl = document.getElementById('qty-' + id);
      if (!qtyEl) return;
      
      let currentQty = parseInt(qtyEl.innerText);
      let newQty = currentQty + change;
      
      if (newQty < 0) newQty = 0;
      
      qtyEl.innerText = newQty;
      
      if (newQty > 0) {
        cart[id] = {
          name: qtyEl.dataset.name,
          price: parseFloat(qtyEl.dataset.price), // Use parseFloat for prices
          qty: newQty
        };
      } else {
        delete cart[id];
      }
      
      renderCart();
    }

    function renderCart() {
      const container = document.getElementById('bn-cart-items');
      const totalEl = document.getElementById('bn-total');
      
      if (Object.keys(cart).length === 0) {
        container.innerHTML = '<p class="bn-empty">Chưa có sản phẩm nào</p>';
        totalEl.innerText = '0đ';
        return;
      }
      
      let html = '';
      let total = 0;
      
      for (const [id, item] of Object.entries(cart)) {
        const itemTotal = item.price * item.qty;
        total += itemTotal;
        html += `
          <div class="bn-cart-item">
            <div class="bn-ci-info">
              <span class="bn-ci-name">${item.name}</span>
              <span class="bn-ci-meta">${item.qty} x ${item.price.toLocaleString('vi-VN')}đ</span>
            </div>
            <div class="bn-ci-total">${itemTotal.toLocaleString('vi-VN')}đ</div>
          </div>
        `;
      }
      
      container.innerHTML = html;
      totalEl.innerText = total.toLocaleString('vi-VN') + 'đ';
    }

    async function checkout() {
      if (Object.keys(cart).length === 0) {
        alert('Vui lòng chọn sản phẩm trước khi thanh toán.');
        return;
      }

      const btn = document.getElementById('btn-checkout');
      btn.innerText = 'Đang xử lý...';
      btn.disabled = true;

      try {
        // Loop through cart and add items to WooCommerce cart via AJAX
        for (const [id, item] of Object.entries(cart)) {
            const formData = new FormData();
            formData.append('product_id', id);
            formData.append('quantity', item.qty);
            
            // Using standard WC add to cart URL
            const response = await fetch('?wc-ajax=add_to_cart', {
                method: 'POST',
                body: formData
            });
            const data = await response.json();
            if (!data.fragments) { // Check if the add to cart was successful
                throw new Error('Failed to add product ' + item.name + ' to cart.');
            }
        }
        
        // Redirect to checkout
        window.location.href = '<?php echo wc_get_checkout_url(); ?>';
        
      } catch (error) {
        console.error('Error:', error);
        alert('Có lỗi xảy ra. Vui lòng thử lại.');
        btn.innerText = 'Thanh toán ngay';
        btn.disabled = false;
      }
    }
  </script>
</main>

<?php get_footer(); ?>
