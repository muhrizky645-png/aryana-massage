<?php
require_once __DIR__ . '/auth.php';
require_login();

$content = json_decode(@file_get_contents(CONTENT_JSON_PATH), true);
if (!is_array($content)) { $content = []; }
$hero = $content['hero'] ?? [];
$slides = $content['slides'] ?? [];
$services = $content['services'] ?? [];
$testimonials = $content['testimonials'] ?? [];
$contact = $content['contact'] ?? [];
$social = $content['social'] ?? [];
$footerData = $content['footer'] ?? [];
$creds = get_credentials();
$msg = $_GET['msg'] ?? '';

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin Panel - Aryana Massage</title>
<style>
  :root{--gold:#D4AF37;--bg:#0B0B0B;--card:#161616;--border:#2B2A26;--ink:#F4EFE3;--muted:#A8A096;}
  *{box-sizing:border-box;}
  body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;background:var(--bg);color:var(--ink);margin:0;padding:0 0 60px;}
  header{background:#141414;padding:18px 24px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:10;}
  header h1{font-size:18px;color:var(--gold);margin:0;font-family:Georgia,serif;}
  header a{color:var(--muted);text-decoration:none;font-size:14px;border:1px solid var(--border);padding:8px 16px;border-radius:999px;}
  header a:hover{color:var(--gold);border-color:var(--gold);}
  .wrap{max-width:920px;margin:0 auto;padding:24px;}
  .banner{background:rgba(212,175,55,.15);border:1px solid var(--gold);color:var(--gold);padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;}
  .card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:24px;margin-bottom:28px;}
  .card h2{font-size:18px;color:var(--gold);margin:0 0 6px;font-family:Georgia,serif;}
  .card .hint{color:var(--muted);font-size:13px;margin-bottom:18px;}
  label{display:block;font-size:13px;color:var(--muted);margin-bottom:6px;margin-top:14px;}
  input[type=text],input[type=url],input[type=password],textarea{width:100%;padding:10px 12px;border-radius:8px;border:1px solid var(--border);background:#0F0F0F;color:var(--ink);font-size:14px;font-family:inherit;}
  textarea{min-height:70px;resize:vertical;}
  input[type=file]{width:100%;color:var(--muted);font-size:13px;margin-top:4px;}
  .row-item{border:1px dashed var(--border);border-radius:10px;padding:16px;margin-bottom:14px;position:relative;}
  .row-item img{max-width:100%;border-radius:8px;margin-top:8px;max-height:120px;object-fit:cover;}
  .del-check{display:flex;align-items:center;gap:8px;margin-top:10px;font-size:13px;color:#ff8b8b;}
  .add-block{border-top:1px solid var(--border);margin-top:18px;padding-top:18px;}
  .add-block h3{font-size:14px;color:var(--gold);margin:0 0 10px;}
  button.save{margin-top:18px;background:var(--gold);color:#20240F;border:none;padding:12px 26px;border-radius:999px;font-weight:700;cursor:pointer;font-size:14px;}
  button.save:hover{background:#e4c24e;}
</style>
</head>
<body>
<header>
  <h1>Admin Panel &middot; Aryana Massage</h1>
  <a href="logout.php">Keluar</a>
</header>
<div class="wrap">
  <?php if ($msg): ?><div class="banner"><?= h($msg) ?></div><?php endif; ?>

  <div class="card">
    <h2>Hero &amp; Banner Teks</h2>
    <div class="hint">Teks utama di bagian paling atas halaman.</div>
    <form method="post" action="save.php">
      <input type="hidden" name="section" value="hero" />
      <label>Label kecil (eyebrow)</label>
      <input type="text" name="hero_eyebrow" value="<?= h($hero['eyebrow'] ?? '') ?>" />
      <label>Judul utama (bagian putih)</label>
      <input type="text" name="hero_title_main" value="<?= h($hero['titleMain'] ?? '') ?>" />
      <label>Judul aksen (bagian emas)</label>
      <input type="text" name="hero_title_accent" value="<?= h($hero['titleAccent'] ?? '') ?>" />
      <label>Deskripsi singkat</label>
      <textarea name="hero_lead"><?= h($hero['lead'] ?? '') ?></textarea>
      <label>Label tahun pengalaman (di slider foto)</label>
      <input type="text" name="about_badge_years" value="<?= h($content['aboutBadgeYears'] ?? '') ?>" />
      <button class="save" type="submit">Simpan Hero</button>
    </form>
  </div>

  <div class="card">
    <h2>Slide Banner Foto</h2>
    <div class="hint">Foto yang berganti-ganti di bagian "Tentang Kami". Centang "Hapus" untuk menghapus slide, atau tambahkan slide baru di bawah (satu per simpan).</div>
    <form method="post" action="save.php" enctype="multipart/form-data">
      <input type="hidden" name="section" value="slides" />
      <input type="hidden" name="total_slides" value="<?= count($slides) ?>" />
      <?php foreach ($slides as $i => $s): ?>
      <div class="row-item">
        <label>Slide #<?= $i + 1 ?></label>
        <img src="<?= h($s['image'] ?? '') ?>" alt="" />
        <input type="hidden" name="slide_image_current_<?= $i ?>" value="<?= h($s['image'] ?? '') ?>" />
        <input type="file" name="slide_image_new_<?= $i ?>" accept="image/*" />
        <div class="del-check"><label style="margin:0;"><input type="checkbox" name="slide_delete_<?= $i ?>" value="1" /> Hapus slide ini</label></div>
      </div>
      <?php endforeach; ?>
      <div class="add-block">
        <h3>+ Tambah slide baru</h3>
        <input type="file" name="new_slide_image" accept="image/*" />
      </div>
      <button class="save" type="submit">Simpan Slide Banner</button>
    </form>
  </div>

  <div class="card">
    <h2>Layanan (Services)</h2>
    <div class="hint">Ganti judul, deskripsi, dan gambar layanan. Centang "Hapus" untuk menghapus layanan, atau tambahkan layanan baru di bawah (satu per simpan).</div>
    <form method="post" action="save.php" enctype="multipart/form-data">
      <input type="hidden" name="section" value="services" />
      <input type="hidden" name="total_services" value="<?= count($services) ?>" />
      <?php foreach ($services as $i => $s): ?>
      <div class="row-item">
        <label>Judul Layanan #<?= $i + 1 ?></label>
        <input type="text" name="svc_title_<?= $i ?>" value="<?= h($s['title'] ?? '') ?>" />
        <label>Deskripsi</label>
        <textarea name="svc_description_<?= $i ?>"><?= h($s['description'] ?? '') ?></textarea>
        <label>Gambar</label>
        <img src="<?= h($s['image'] ?? '') ?>" alt="" />
        <input type="hidden" name="svc_image_current_<?= $i ?>" value="<?= h($s['image'] ?? '') ?>" />
        <input type="file" name="svc_image_new_<?= $i ?>" accept="image/*" />
        <div class="del-check"><label style="margin:0;"><input type="checkbox" name="svc_delete_<?= $i ?>" value="1" /> Hapus layanan ini</label></div>
      </div>
      <?php endforeach; ?>
      <div class="add-block">
        <h3>+ Tambah layanan baru</h3>
        <label>Judul</label>
        <input type="text" name="new_svc_title" />
        <label>Deskripsi</label>
        <textarea name="new_svc_description"></textarea>
        <label>Gambar</label>
        <input type="file" name="new_svc_image" accept="image/*" />
      </div>
      <button class="save" type="submit">Simpan Layanan</button>
    </form>
  </div>

  <div class="card">
    <h2>Testimoni</h2>
    <div class="hint">Ulasan pelanggan yang tampil di halaman.</div>
    <form method="post" action="save.php">
      <input type="hidden" name="section" value="testimonials" />
      <input type="hidden" name="total_testimonials" value="<?= count($testimonials) ?>" />
      <?php foreach ($testimonials as $i => $t): ?>
      <div class="row-item">
        <label>Testimoni #<?= $i + 1 ?></label>
        <textarea name="testi_quote_<?= $i ?>"><?= h($t['quote'] ?? '') ?></textarea>
        <label>Nama</label>
        <input type="text" name="testi_name_<?= $i ?>" value="<?= h($t['name'] ?? '') ?>" />
        <label>Lokasi</label>
        <input type="text" name="testi_location_<?= $i ?>" value="<?= h($t['location'] ?? '') ?>" />
        <div class="del-check"><label style="margin:0;"><input type="checkbox" name="testi_delete_<?= $i ?>" value="1" /> Hapus testimoni ini</label></div>
      </div>
      <?php endforeach; ?>
      <div class="add-block">
        <h3>+ Tambah testimoni baru</h3>
        <label>Isi testimoni</label>
        <textarea name="new_testi_quote"></textarea>
        <label>Nama</label>
        <input type="text" name="new_testi_name" />
        <label>Lokasi</label>
        <input type="text" name="new_testi_location" />
      </div>
      <button class="save" type="submit">Simpan Testimoni</button>
    </form>
  </div>

  <div class="card">
    <h2>Kontak &amp; Sosial Media</h2>
    <form method="post" action="save.php">
      <input type="hidden" name="section" value="contact" />
      <label>Nomor WhatsApp (format 62xxxxxxxxxx, tanpa +/spasi)</label>
      <input type="text" name="contact_whatsapp" value="<?= h($contact['whatsapp'] ?? '') ?>" />
      <label>Nomor tampilan (misal 0831-6526-2513)</label>
      <input type="text" name="contact_whatsapp_display" value="<?= h($contact['whatsappDisplay'] ?? '') ?>" />
      <label>Alamat</label>
      <input type="text" name="contact_address" value="<?= h($contact['address'] ?? '') ?>" />
      <button class="save" type="submit">Simpan Kontak</button>
    </form>
    <form method="post" action="save.php" style="margin-top:24px;border-top:1px solid var(--border);padding-top:18px;">
      <input type="hidden" name="section" value="social" />
      <label>Link Facebook</label>
      <input type="url" name="social_facebook" value="<?= h($social['facebook'] ?? '') ?>" />
      <label>Link TikTok</label>
      <input type="url" name="social_tiktok" value="<?= h($social['tiktok'] ?? '') ?>" />
      <label>Link Instagram</label>
      <input type="url" name="social_instagram" value="<?= h($social['instagram'] ?? '') ?>" />
      <button class="save" type="submit">Simpan Sosial Media</button>
    </form>
  </div>

  <div class="card">
    <h2>Footer</h2>
    <form method="post" action="save.php">
      <input type="hidden" name="section" value="footer" />
      <label>Deskripsi singkat di footer</label>
      <textarea name="footer_description"><?= h($footerData['description'] ?? '') ?></textarea>
      <label>Teks hak cipta</label>
      <input type="text" name="footer_copyright" value="<?= h($footerData['copyright'] ?? '') ?>" />
      <button class="save" type="submit">Simpan Footer</button>
    </form>
  </div>

  <div class="card">
    <h2>Keamanan</h2>
    <div class="hint">Username saat ini: <strong><?= h($creds['username']) ?></strong>. Ganti username &amp; password admin di sini.</div>
    <form method="post" action="save.php">
      <input type="hidden" name="section" value="credentials" />
      <label>Password saat ini</label>
      <input type="password" name="current_password" required />
      <label>Username baru</label>
      <input type="text" name="new_username" value="<?= h($creds['username']) ?>" required />
      <label>Password baru</label>
      <input type="password" name="new_password" required />
      <label>Konfirmasi password baru</label>
      <input type="password" name="confirm_password" required />
      <button class="save" type="submit">Ganti Username &amp; Password</button>
    </form>
  </div>

</div>
</body>
</html>
