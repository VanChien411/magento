<?php
$issues = [];

// Kiểm tra file logo
$logoPath = '/var/www/html/magento/app/design/frontend/Packt/cookbook/web/images/logo.png';
$logoPublicPath = '/var/www/html/magento/pub/static/frontend/Packt/cookbook/en_US/images/logo.png';

if (!file_exists($logoPath)) {
    $issues[] = "Logo không tồn tại tại đường dẫn theme: $logoPath";
}
if (!file_exists($logoPublicPath)) {
    $issues[] = "Logo chưa được deploy vào thư mục pub/static";
}

// Kiểm tra Block class
$blockClassPath = '/var/www/html/magento/app/code/MyVendor/MyModule/Block/MyCustomBlock.php';
if (!file_exists($blockClassPath)) {
    $issues[] = "Block class không tồn tại tại: $blockClassPath";
}

// 2. Kiểm tra theme đang active
$themeConfig = '/var/www/html/magento/app/etc/config.php';
if (file_exists($themeConfig)) {
    $config = include $themeConfig;
    if (!isset($config['design']['theme']['frontend/Packt/cookbook'])) {
        $issues[] = "Theme Packt/cookbook chưa được kích hoạt";
    }
}

// 3. Kiểm tra CMS Block
require_once '/var/www/html/magento/app/bootstrap.php';
$bootstrap = \Magento\Framework\App\Bootstrap::create(BP, $_SERVER);
$objectManager = $bootstrap->getObjectManager();

try {
    $block = $objectManager->get(\Magento\Cms\Model\Block::class)->load('custom_block', 'identifier');
    if (!$block->getId()) {
        $issues[] = "Block với identifier 'custom_block' không tồn tại";
    } elseif (!$block->getIsActive()) {
        $issues[] = "Block 'custom_block' chưa được kích hoạt";
    }
} catch (\Exception $e) {
    $issues[] = "Lỗi khi kiểm tra block: " . $e->getMessage();
}

// In kết quả
if (empty($issues)) {
    echo "Không tìm thấy vấn đề về cấu hình. Hãy kiểm tra:\n";
    echo "1. Đã chạy lệnh php bin/magento setup:static-content:deploy -f chưa?\n";
    echo "2. Đã xóa cache với php bin/magento cache:flush chưa?\n";
    echo "3. Kiểm tra permissions của các thư mục var và pub/static\n";
} else {
    echo "Các vấn đề tìm thấy:\n";
    foreach ($issues as $issue) {
        echo "- $issue\n";
    }
}
