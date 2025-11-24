<?php
/**
 * Custom Credit Card Payment Gateway for Movie Booking
 * 
 * @package MovieTheme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * WC_Gateway_Credit_Card class
 */
class WC_Gateway_Credit_Card extends WC_Payment_Gateway {

    /**
     * Constructor
     */
    public function __construct() {
        $this->id                 = 'credit_card';
        $this->icon               = '';
        $this->has_fields         = true;
        $this->method_title        = __('Thẻ tín dụng/Ghi nợ', 'movie-theme');
        $this->method_description  = __('Thanh toán bằng thẻ tín dụng hoặc thẻ ghi nợ', 'movie-theme');
        $this->supports           = array(
            'products',
        );
        
        // Đảm bảo gateway luôn available khi enabled
        $this->method_title = $this->method_title ?: 'Thẻ tín dụng/Ghi nợ';

        // Load the settings
        $this->init_form_fields();
        $this->init_settings();

        // Define user set variables
        $this->title        = $this->get_option('title', 'Thẻ tín dụng/Ghi nợ');
        $this->description  = $this->get_option('description', 'Thanh toán bằng thẻ Visa, Mastercard, JCB, hoặc thẻ ghi nợ');
        $this->enabled      = $this->get_option('enabled', 'yes');
        $this->testmode     = $this->get_option('testmode', 'yes') === 'yes';
        $this->api_key      = $this->get_option('api_key', '');
        $this->api_secret   = $this->get_option('api_secret', '');
        
        // Đảm bảo enabled mặc định là 'yes' nếu chưa được set
        if (empty($this->enabled)) {
            $this->enabled = 'yes';
            $this->update_option('enabled', 'yes');
        }

        // Actions
        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_api_wc_gateway_credit_card', array($this, 'check_response'));
    }

    /**
     * Initialize Gateway Settings Form Fields
     */
    public function init_form_fields() {
        $this->form_fields = array(
            'enabled' => array(
                'title'       => __('Bật/Tắt', 'movie-theme'),
                'label'       => __('Bật thanh toán bằng thẻ', 'movie-theme'),
                'type'        => 'checkbox',
                'description' => '',
                'default'     => 'yes',
            ),
            'title' => array(
                'title'       => __('Tiêu đề', 'movie-theme'),
                'type'        => 'text',
                'description' => __('Tiêu đề hiển thị cho khách hàng', 'movie-theme'),
                'default'     => __('Thẻ tín dụng/Ghi nợ', 'movie-theme'),
                'desc_tip'    => true,
            ),
            'description' => array(
                'title'       => __('Mô tả', 'movie-theme'),
                'type'        => 'textarea',
                'description' => __('Mô tả phương thức thanh toán', 'movie-theme'),
                'default'     => __('Thanh toán bằng thẻ Visa, Mastercard, JCB, hoặc thẻ ghi nợ', 'movie-theme'),
            ),
            'testmode' => array(
                'title'       => __('Chế độ test', 'movie-theme'),
                'label'       => __('Bật chế độ test', 'movie-theme'),
                'type'        => 'checkbox',
                'description' => __('Chế độ test cho phép thanh toán với thẻ test', 'movie-theme'),
                'default'     => 'yes',
            ),
            'api_key' => array(
                'title'       => __('API Key', 'movie-theme'),
                'type'        => 'text',
                'description' => __('API Key từ payment provider (nếu có)', 'movie-theme'),
                'default'     => '',
            ),
            'api_secret' => array(
                'title'       => __('API Secret', 'movie-theme'),
                'type'        => 'password',
                'description' => __('API Secret từ payment provider (nếu có)', 'movie-theme'),
                'default'     => '',
            ),
        );
    }

    /**
     * Check if this gateway is available for use
     */
    public function is_available() {
        // Chỉ available khi enabled
        if ($this->enabled !== 'yes') {
            return false;
        }
        
        // Luôn available nếu enabled (không có điều kiện đặc biệt)
        return true;
    }

    /**
     * Payment fields on checkout page
     */
    public function payment_fields() {
        if ($this->description) {
            echo wpautop(wptexturize($this->description));
        }

        if ($this->testmode) {
            echo '<div class="woocommerce-info" style="background: rgba(255, 193, 7, 0.1); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 8px; padding: 15px; margin: 15px 0; color: #fbbf24;">';
            echo '<strong>' . __('Chế độ test:', 'movie-theme') . '</strong> ';
            echo __('Sử dụng thẻ test: 4242 4242 4242 4242, CVV: 123, Ngày hết hạn: bất kỳ ngày tương lai nào', 'movie-theme');
            echo '</div>';
        }
        ?>
        <fieldset id="wc-<?php echo esc_attr($this->id); ?>-cc-form" class="wc-credit-card-form wc-payment-form" style="background:transparent;">
            <div class="form-row form-row-wide">
                <label for="<?php echo esc_attr($this->id); ?>-card-number">
                    <?php echo __('Số thẻ', 'movie-theme'); ?> <span class="required">*</span>
                </label>
                <input id="<?php echo esc_attr($this->id); ?>-card-number" 
                       class="input-text wc-credit-card-form-card-number" 
                       type="text" 
                       maxlength="20" 
                       autocomplete="cc-number" 
                       placeholder="1234 5678 9012 3456"
                       name="<?php echo esc_attr($this->id); ?>-card-number" />
            </div>
            <div class="form-row form-row-first">
                <label for="<?php echo esc_attr($this->id); ?>-card-expiry">
                    <?php echo __('Ngày hết hạn (MM/YY)', 'movie-theme'); ?> <span class="required">*</span>
                </label>
                <input id="<?php echo esc_attr($this->id); ?>-card-expiry" 
                       class="input-text wc-credit-card-form-card-expiry" 
                       type="text" 
                       autocomplete="cc-exp" 
                       placeholder="MM / YY"
                       name="<?php echo esc_attr($this->id); ?>-card-expiry" />
            </div>
            <div class="form-row form-row-last">
                <label for="<?php echo esc_attr($this->id); ?>-card-cvc">
                    <?php echo __('CVV', 'movie-theme'); ?> <span class="required">*</span>
                </label>
                <input id="<?php echo esc_attr($this->id); ?>-card-cvc" 
                       class="input-text wc-credit-card-form-card-cvc" 
                       type="text" 
                       autocomplete="cc-csc" 
                       placeholder="CVV"
                       name="<?php echo esc_attr($this->id); ?>-card-cvc" />
            </div>
            <div class="form-row form-row-wide">
                <label for="<?php echo esc_attr($this->id); ?>-card-name">
                    <?php echo __('Tên in trên thẻ', 'movie-theme'); ?> <span class="required">*</span>
                </label>
                <input id="<?php echo esc_attr($this->id); ?>-card-name" 
                       class="input-text" 
                       type="text" 
                       autocomplete="cc-name"
                       placeholder="<?php echo esc_attr__('NGUYEN VAN A', 'movie-theme'); ?>"
                       name="<?php echo esc_attr($this->id); ?>-card-name" />
            </div>
            <div class="clear"></div>
        </fieldset>
        <?php
    }

    /**
     * Validate payment fields
     */
    public function validate_fields() {
        $card_number = isset($_POST[$this->id . '-card-number']) ? sanitize_text_field($_POST[$this->id . '-card-number']) : '';
        $card_expiry = isset($_POST[$this->id . '-card-expiry']) ? sanitize_text_field($_POST[$this->id . '-card-expiry']) : '';
        $card_cvc    = isset($_POST[$this->id . '-card-cvc']) ? sanitize_text_field($_POST[$this->id . '-card-cvc']) : '';
        $card_name   = isset($_POST[$this->id . '-card-name']) ? sanitize_text_field($_POST[$this->id . '-card-name']) : '';

        // Remove spaces from card number
        $card_number = preg_replace('/\s+/', '', $card_number);

        // Validate card number (Luhn algorithm)
        if (empty($card_number) || !$this->validate_card_number($card_number)) {
            wc_add_notice(__('Số thẻ không hợp lệ.', 'movie-theme'), 'error');
            return false;
        }

        // Validate expiry date
        if (empty($card_expiry) || !$this->validate_expiry_date($card_expiry)) {
            wc_add_notice(__('Ngày hết hạn không hợp lệ. Vui lòng nhập theo định dạng MM/YY.', 'movie-theme'), 'error');
            return false;
        }

        // Validate CVV
        if (empty($card_cvc) || !preg_match('/^\d{3,4}$/', $card_cvc)) {
            wc_add_notice(__('CVV không hợp lệ. CVV phải có 3 hoặc 4 chữ số.', 'movie-theme'), 'error');
            return false;
        }

        // Validate card name
        if (empty($card_name)) {
            wc_add_notice(__('Vui lòng nhập tên in trên thẻ.', 'movie-theme'), 'error');
            return false;
        }

        return true;
    }

    /**
     * Validate card number using Luhn algorithm
     */
    private function validate_card_number($number) {
        // Remove non-numeric characters
        $number = preg_replace('/\D/', '', $number);
        
        // Check if it's a valid length (13-19 digits)
        if (strlen($number) < 13 || strlen($number) > 19) {
            return false;
        }

        // Luhn algorithm
        $sum = 0;
        $numDigits = strlen($number);
        $parity = $numDigits % 2;

        for ($i = 0; $i < $numDigits; $i++) {
            $digit = intval($number[$i]);
            if ($i % 2 == $parity) {
                $digit *= 2;
            }
            if ($digit > 9) {
                $digit -= 9;
            }
            $sum += $digit;
        }

        return ($sum % 10) == 0;
    }

    /**
     * Validate expiry date
     */
    private function validate_expiry_date($expiry) {
        $expiry = trim($expiry);
        if (!preg_match('/^(\d{2})\s*\/\s*(\d{2})$/', $expiry, $matches)) {
            return false;
        }

        $month = intval($matches[1]);
        $year = intval($matches[2]);

        // Convert 2-digit year to 4-digit
        if ($year < 100) {
            $year += 2000;
        }

        // Check if month is valid
        if ($month < 1 || $month > 12) {
            return false;
        }

        // Check if date is in the future
        $current_year = (int) date('Y');
        $current_month = (int) date('m');
        
        // Nếu năm nhỏ hơn năm hiện tại thì invalid
        if ($year < $current_year) {
            return false;
        }
        
        // Nếu cùng năm nhưng tháng đã qua thì invalid
        if ($year == $current_year && $month < $current_month) {
            return false;
        }
        
        // Nếu năm quá xa trong tương lai (ví dụ > 20 năm) thì có thể invalid
        if ($year > $current_year + 20) {
            return false;
        }
        
        return true;
    }

    /**
     * Process the payment
     */
    public function process_payment($order_id) {
        $order = wc_get_order($order_id);

        if (!$order) {
            return array(
                'result'   => 'fail',
                'redirect' => '',
            );
        }

        // Validate fields
        if (!$this->validate_fields()) {
            return array(
                'result'   => 'fail',
                'redirect' => '',
            );
        }

        // Get card details
        $card_number = preg_replace('/\s+/', '', sanitize_text_field($_POST[$this->id . '-card-number']));
        $card_expiry = sanitize_text_field($_POST[$this->id . '-card-expiry']);
        $card_cvc    = sanitize_text_field($_POST[$this->id . '-card-cvc']);
        $card_name   = sanitize_text_field($_POST[$this->id . '-card-name']);

        // Mask card number for storage (only last 4 digits)
        $card_last4 = substr($card_number, -4);
        $card_masked = '**** **** **** ' . $card_last4;

        // Store card info in order meta (masked)
        $order->update_meta_data('_card_last4', $card_last4);
        $order->update_meta_data('_card_expiry', $card_expiry);
        $order->update_meta_data('_card_name', $card_name);
        $order->update_meta_data('_payment_method_title', $this->title . ' (' . $card_masked . ')');

        // Process payment
        // In production, you would integrate with a real payment gateway API here
        // For demo/test mode, we'll simulate a successful payment
        if ($this->testmode) {
            // Test mode: Always succeed for demo purposes
            $payment_result = $this->process_test_payment($order, $card_number);
        } else {
            // Production mode: Call real payment gateway API
            $payment_result = $this->process_real_payment($order, $card_number, $card_expiry, $card_cvc, $card_name);
        }

        if ($payment_result['success']) {
            // Payment successful
            $order->payment_complete();
            
            // Lưu transaction ID (trong test mode, dùng timestamp)
            $transaction_id = $this->testmode ? 'TEST-' . time() : 'TXN-' . time();
            $order->set_transaction_id($transaction_id);
            $order->save();
            
            $order->add_order_note(sprintf(
                __('Thanh toán thành công bằng thẻ. Số thẻ: %s, Transaction ID: %s', 'movie-theme'),
                $card_masked,
                $transaction_id
            ));

            // Remove cart
            WC()->cart->empty_cart();

            // Redirect về trang order-success thay vì WooCommerce thank you page
            $success_page = get_page_by_path('order-success');
            $success_url = $success_page ? get_permalink($success_page->ID) : home_url('/order-success/');
            $success_url = add_query_arg('order_id', $order_id, $success_url);
            // Thêm wc_order_id để trang success có thể lấy WooCommerce order
            $success_url = add_query_arg('wc_order_id', $order_id, $success_url);

            // Return success page redirect
            return array(
                'result'   => 'success',
                'redirect' => $success_url,
            );
        } else {
            // Payment failed - set order status to failed
            $order->update_status('failed', sprintf(
                __('Thanh toán thất bại: %s', 'movie-theme'),
                $payment_result['message']
            ));

            wc_add_notice($payment_result['message'], 'error');

            return array(
                'result'   => 'fail',
                'redirect' => '',
            );
        }
    }

    /**
     * Process test payment (for demo purposes)
     */
    private function process_test_payment($order, $card_number) {
        // In test mode, accept certain test card numbers
        $test_cards = array(
            '4242424242424242', // Visa test card - success
            '4000000000000002', // Visa test card - declined
            '5555555555554444', // Mastercard test card - success
            '4000000000009995', // Visa test card - insufficient funds
        );

        // Simulate processing delay (không dùng sleep trong production)
        // sleep(1);

        // Check if it's a known test card
        if (in_array($card_number, $test_cards)) {
            if ($card_number === '4000000000000002') {
                return array(
                    'success' => false,
                    'message' => __('Thẻ bị từ chối. Vui lòng thử thẻ khác.', 'movie-theme'),
                );
            }
            if ($card_number === '4000000000009995') {
                return array(
                    'success' => false,
                    'message' => __('Số dư không đủ. Vui lòng thử thẻ khác.', 'movie-theme'),
                );
            }
            // Success for other test cards
            return array(
                'success' => true,
                'message' => __('Thanh toán thành công (chế độ test)', 'movie-theme'),
            );
        }

        // For other cards in test mode, validate using Luhn algorithm
        // Nếu pass Luhn check thì accept (để dễ test)
        if ($this->validate_card_number($card_number)) {
            // Kiểm tra một số pattern để simulate các trường hợp khác nhau
            $last_digit = substr($card_number, -1);
            
            // Card ending in 5 = declined
            if ($last_digit === '5') {
                return array(
                    'success' => false,
                    'message' => __('Thẻ bị từ chối. Vui lòng thử thẻ khác.', 'movie-theme'),
                );
            }
            
            // Card ending in 9 = insufficient funds
            if ($last_digit === '9') {
                return array(
                    'success' => false,
                    'message' => __('Số dư không đủ. Vui lòng thử thẻ khác.', 'movie-theme'),
                );
            }
            
            // Otherwise success
            return array(
                'success' => true,
                'message' => __('Thanh toán thành công (chế độ test)', 'movie-theme'),
            );
        }

        return array(
            'success' => false,
            'message' => __('Số thẻ không hợp lệ. Vui lòng kiểm tra lại.', 'movie-theme'),
        );
    }

    /**
     * Process real payment (integrate with payment gateway API)
     */
    private function process_real_payment($order, $card_number, $card_expiry, $card_cvc, $card_name) {
        // TODO: Integrate with real payment gateway API (Stripe, PayPal, VNPay, etc.)
        // Example structure:
        /*
        $api_url = 'https://api.payment-gateway.com/charge';
        $response = wp_remote_post($api_url, array(
            'body' => array(
                'api_key' => $this->api_key,
                'api_secret' => $this->api_secret,
                'amount' => $order->get_total() * 100, // Convert to cents
                'currency' => get_woocommerce_currency(),
                'card_number' => $card_number,
                'card_expiry' => $card_expiry,
                'card_cvc' => $card_cvc,
                'card_name' => $card_name,
            ),
        ));

        if (is_wp_error($response)) {
            return array(
                'success' => false,
                'message' => $response->get_error_message(),
            );
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        
        if (isset($body['success']) && $body['success']) {
            return array(
                'success' => true,
                'message' => 'Payment successful',
            );
        } else {
            return array(
                'success' => false,
                'message' => $body['message'] ?? 'Payment failed',
            );
        }
        */

        // For now, return error in production mode if no API is configured
        return array(
            'success' => false,
            'message' => __('Vui lòng cấu hình API key và API secret trong cài đặt thanh toán.', 'movie-theme'),
        );
    }

    /**
     * Check response from payment gateway
     */
    public function check_response() {
        // Handle webhook/callback from payment gateway if needed
    }
}

