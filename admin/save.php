<?php
require_once __DIR__ . '/auth.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

function upload_image($fileKey) {
    if (!empty($_FILES[$fileKey]['name']) && $_FILES[$fileKey]['error'] === UPLOAD_ERR_OK) {
        $tmp = $_FILES[$fileKey]['tmp_name'];
        $ext = strtolower(pathinfo($_FILES[$fileKey]['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (!in_array($ext, $allowed, true)) return null;
        if ($_FILES[$fileKey]['size'] > 5 * 1024 * 1024) return null;
        if (!is_dir(UPLOADS_DIR)) { @mkdir(UPLOADS_DIR, 0755, true); }
        $newName = 'img_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
        $dest = UPLOADS_DIR . '/' . $newName;
        if (move_uploaded_file($tmp, $dest)) {
            return UPLOADS_URL_PREFIX . '/' . $newName;
        }
    }
    return null;
}

$section = $_POST['section'] ?? '';

if ($section === 'credentials') {
    $creds = get_credentials();
    $current = $_POST['current_password'] ?? '';
    $newUser = trim($_POST['new_username'] ?? '');
    $newPass = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if (!hash_equals((string)$creds['password'], (string)$current)) {
        header('Location: index.php?msg=' . urlencode('Password saat ini salah. Perubahan tidak disimpan.'));
        exit;
    }
    if ($newUser === '' || $newPass === '') {
        header('Location: index.php?msg=' . urlencode('Username dan password baru wajib diisi.'));
        exit;
    }
    if ($newPass !== $confirm) {
        header('Location: index.php?msg=' . urlencode('Konfirmasi password baru tidak cocok.'));
        exit;
    }
    $newCreds = ['username' => $newUser, 'password' => $newPass];
    file_put_contents(CREDENTIALS_PATH, "<?php\nreturn " . var_export($newCreds, true) . ";\n");
    $_SESSION = [];
    session_destroy();
    header('Location: login.php?msg=' . urlencode('Username & password berhasil diganti. Silakan login ulang.'));
    exit;
}

$content = json_decode(@file_get_contents(CONTENT_JSON_PATH), true);
if (!is_array($content)) { $content = []; }

$message = 'Perubahan berhasil disimpan.';

if ($section === 'hero') {
    $content['hero']['eyebrow'] = trim($_POST['hero_eyebrow'] ?? '');
    $content['hero']['titleMain'] = trim($_POST['hero_title_main'] ?? '');
    $content['hero']['titleAccent'] = trim($_POST['hero_title_accent'] ?? '');
    $content['hero']['lead'] = trim($_POST['hero_lead'] ?? '');
    $content['aboutBadgeYears'] = trim($_POST['about_badge_years'] ?? '');
} elseif ($section === 'slides') {
    $total = (int)($_POST['total_slides'] ?? 0);
    $newSlides = [];
    for ($i = 0; $i < $total; $i++) {
        if (!empty($_POST['slide_delete_' . $i])) continue;
        $current = $_POST['slide_image_current_' . $i] ?? '';
        $uploaded = upload_image('slide_image_new_' . $i);
        $img = $uploaded ?: $current;
        if ($img !== '') $newSlides[] = ['image' => $img];
    }
    $newImg = upload_image('new_slide_image');
    if ($newImg) $newSlides[] = ['image' => $newImg];
    if (count($newSlides) > 0) {
        $content['slides'] = $newSlides;
    } else {
        $message = 'Minimal harus ada 1 slide banner. Perubahan tidak disimpan.';
    }
} elseif ($section === 'services') {
    $total = (int)($_POST['total_services'] ?? 0);
    $newServices = [];
    for ($i = 0; $i < $total; $i++) {
        if (!empty($_POST['svc_delete_' . $i])) continue;
        $title = trim($_POST['svc_title_' . $i] ?? '');
        $desc = trim($_POST['svc_description_' . $i] ?? '');
        $current = $_POST['svc_image_current_' . $i] ?? '';
        $uploaded = upload_image('svc_image_new_' . $i);
        $img = $uploaded ?: $current;
        if ($title !== '' && $img !== '') {
            $newServices[] = ['title' => $title, 'description' => $desc, 'image' => $img];
        }
    }
    $newTitle = trim($_POST['new_svc_title'] ?? '');
    $newDesc = trim($_POST['new_svc_description'] ?? '');
    $newImgSvc = upload_image('new_svc_image');
    if ($newTitle !== '' && $newImgSvc) {
        $newServices[] = ['title' => $newTitle, 'description' => $newDesc, 'image' => $newImgSvc];
    }
    if (count($newServices) > 0) {
        $content['services'] = $newServices;
    } else {
        $message = 'Minimal harus ada 1 layanan. Perubahan tidak disimpan.';
    }
} elseif ($section === 'testimonials') {
    $total = (int)($_POST['total_testimonials'] ?? 0);
    $newTesti = [];
    for ($i = 0; $i < $total; $i++) {
        if (!empty($_POST['testi_delete_' . $i])) continue;
        $quote = trim($_POST['testi_quote_' . $i] ?? '');
        $name = trim($_POST['testi_name_' . $i] ?? '');
        $loc = trim($_POST['testi_location_' . $i] ?? '');
        if ($quote !== '' && $name !== '') {
            $newTesti[] = ['quote' => $quote, 'name' => $name, 'location' => $loc];
        }
    }
    $nq = trim($_POST['new_testi_quote'] ?? '');
    $nn = trim($_POST['new_testi_name'] ?? '');
    $nl = trim($_POST['new_testi_location'] ?? '');
    if ($nq !== '' && $nn !== '') {
        $newTesti[] = ['quote' => $nq, 'name' => $nn, 'location' => $nl];
    }
    $content['testimonials'] = $newTesti;
} elseif ($section === 'contact') {
    $content['contact']['whatsapp'] = preg_replace('/\D/', '', $_POST['contact_whatsapp'] ?? '');
    $content['contact']['whatsappDisplay'] = trim($_POST['contact_whatsapp_display'] ?? '');
    $content['contact']['address'] = trim($_POST['contact_address'] ?? '');
} elseif ($section === 'social') {
    $content['social']['facebook'] = trim($_POST['social_facebook'] ?? '');
    $content['social']['tiktok'] = trim($_POST['social_tiktok'] ?? '');
    $content['social']['instagram'] = trim($_POST['social_instagram'] ?? '');
} elseif ($section === 'footer') {
    $content['footer']['description'] = trim($_POST['footer_description'] ?? '');
    $content['footer']['copyright'] = trim($_POST['footer_copyright'] ?? '');
} else {
    $message = 'Bagian tidak dikenali.';
}

file_put_contents(CONTENT_JSON_PATH, json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

header('Location: index.php?msg=' . urlencode($message));
exit;
