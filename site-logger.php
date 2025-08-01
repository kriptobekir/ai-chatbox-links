<?php
// Site Logger - Hangi sitelerde eklenti kurulu olduğunu takip eder
// Bu dosyayı GitHub'da barındırabilirsin

$log_file = 'sites-log.json';

// Gelen site bilgisini al
$site_domain = $_GET['domain'] ?? '';
$site_url = $_GET['url'] ?? '';
$action = $_GET['action'] ?? '';

if ($site_domain && $action === 'register') {
    // Site kaydını yap
    $sites = [];
    if (file_exists($log_file)) {
        $sites = json_decode(file_get_contents($log_file), true) ?? [];
    }
    
    $sites[$site_domain] = [
        'domain' => $site_domain,
        'url' => $site_url,
        'registered_at' => date('Y-m-d H:i:s'),
        'last_seen' => date('Y-m-d H:i:s'),
        'active' => true
    ];
    
    file_put_contents($log_file, json_encode($sites, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
}

if ($action === 'ping') {
    // Site hala aktif mi kontrol et
    $sites = [];
    if (file_exists($log_file)) {
        $sites = json_decode(file_get_contents($log_file), true) ?? [];
    }
    
    if (isset($sites[$site_domain])) {
        $sites[$site_domain]['last_seen'] = date('Y-m-d H:i:s');
        file_put_contents($log_file, json_encode($sites, JSON_PRETTY_PRINT));
    }
    
    echo json_encode(['success' => true]);
}
?> 