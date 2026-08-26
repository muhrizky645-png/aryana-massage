<?php
$contentPath = __DIR__ . '/content.json';
$content = [];
if (file_exists($contentPath)) {
    $decoded = json_decode(file_get_contents($contentPath), true);
    if (is_array($decoded)) { $content = $decoded; }
}
function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
$hero = $content['hero'] ?? [];
$aboutBadgeYears = $content['aboutBadgeYears'] ?? '10+ Tahun';
$slides = $content['slides'] ?? [];
$services = $content['services'] ?? [];
$testimonials = $content['testimonials'] ?? [];
$contact = $content['contact'] ?? [];
$social = $content['social'] ?? [];
$footerData = $content['footer'] ?? [];

$svcIcons = [
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 16.5A4.5 4.5 0 1 1 7.5 12 4.5 4.5 0 1 1 12 7.5a4.5 4.5 0 1 1 4.5 4.5 4.5 4.5 0 1 1-4.5 4.5"/><path d="m8 8 1.88 1.88M14.12 9.88 16 8m-8 8 1.88-1.88M14.12 14.12 16 16"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 16v-2.38C4 11.5 2.97 10.5 3 8c.03-2.72 1.49-6 4.5-6C9.37 2 10 3.8 10 5.5c0 3.11-2 5.66-2 8.68V16a2 2 0 1 1-4 0Z"/><path d="M20 20v-2.38c0-2.12 1.03-3.12 1-5.62-.03-2.72-1.49-6-4.5-6C14.63 6 14 7.8 14 9.5c0 3.11 2 5.66 2 8.68V20a2 2 0 1 0 4 0Z"/><path d="M16 17h4M4 13h4"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9.94 14.34A2 2 0 0 0 8.66 13L4.5 11.6a.5.5 0 0 1 0-.95L8.66 9.2a2 2 0 0 0 1.28-1.28L11.34 3.5a.5.5 0 0 1 .95 0l1.4 4.42a2 2 0 0 0 1.28 1.28l4.16 1.45a.5.5 0 0 1 0 .95l-4.16 1.34a2 2 0 0 0-1.28 1.28l-1.4 4.42a.5.5 0 0 1-.95 0z"/><path d="M20 3v4M22 5h-4M4 17v2M5 18H3"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C3 11.1 5 13 5 15a7 7 0 0 0 7 7z"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 16v-2.38C4 11.5 2.97 10.5 3 8c.03-2.72 1.49-6 4.5-6C9.37 2 10 3.8 10 5.5c0 3.11-2 5.66-2 8.68V16a2 2 0 1 1-4 0Z"/><path d="M20 20v-2.38c0-2.12 1.03-3.12 1-5.62-.03-2.72-1.49-6-4.5-6C14.63 6 14 7.8 14 9.5c0 3.11 2 5.66 2 8.68V20a2 2 0 1 0 4 0Z"/><path d="M16 17h4M4 13h4"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M18 11V6a2 2 0 0 0-2-2 2 2 0 0 0-2 2"/><path d="M14 10V4a2 2 0 0 0-2-2 2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2 2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12.8 19.6A2 2 0 1 0 14 16H2m10.5-11.4A2 2 0 1 1 14 8H2m15.5 9.6A2 2 0 1 0 19 14H2"/></svg>',
  '<svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.02 4.1a.56.56 0 0 0 .42.3l4.52.66c.5.07.7.68.34 1.03l-3.27 3.19a.56.56 0 0 0-.16.5l.77 4.5c.09.5-.44.88-.88.64l-4.04-2.13a.56.56 0 0 0-.52 0l-4.04 2.13c-.44.24-.97-.14-.88-.64l.77-4.5a.56.56 0 0 0-.16-.5L3.42 9.59c-.36-.35-.16-.96.34-1.03l4.52-.66a.56.56 0 0 0 .42-.3z"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>',
  '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>'
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Aryana Massage - Pijat Panggilan Profesional ke Rumah Anda</title>
<style>
  :root{
    --forest:#141414;
    --forest-2:#242424;
    --sage:#6E6459;
    --gold:#D4AF37;
    --gold-2:#C9A24B;
    --gold-soft:#241F13;
    --cream:#0B0B0B;
    --cream-2:#131313;
    --ink:#F4EFE3;
    --muted:#A8A096;
    --border:#2B2A26;
    --white:#1A1A1A;
    --radius:14px;
    --shadow:0 1px 2px rgba(0,0,0,.4), 0 10px 30px rgba(0,0,0,.5);
  }
  *{box-sizing:border-box;margin:0;padding:0;}
  html{scroll-behavior:smooth;}
  body{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;color:var(--ink);background:var(--cream);line-height:1.6;font-size:16px;}
  h1,h2,h3,h4{font-family:Georgia,"Times New Roman",serif;line-height:1.2;letter-spacing:-.01em;}
  .wrap{max-width:1120px;margin:0 auto;padding:0 24px;}
  .accent{color:var(--gold);}
  .eyebrow{text-transform:uppercase;letter-spacing:.22em;font-size:12px;font-weight:700;color:var(--gold);font-family:-apple-system,sans-serif;margin-bottom:14px;}
  .btn{display:inline-block;background:var(--gold);color:#20240F;font-weight:700;padding:14px 30px;border-radius:999px;text-decoration:none;font-size:15px;transition:transform .2s ease, box-shadow .2s ease;border:none;cursor:pointer;}
  .btn:hover{transform:translateY(-2px);box-shadow:0 8px 22px rgba(201,162,75,.4);}
  .btn-outline{background:transparent;color:#F4EFE3;border:1.5px solid rgba(212,175,55,.6);}
  .btn-outline:hover{background:rgba(255,255,255,.12);box-shadow:none;}
  svg{display:block;}
  .logo .mark svg,.foot-logo .mark svg{width:20px;height:20px;color:var(--gold);}
  .burger svg{width:26px;height:26px;margin:auto;color:var(--gold);}
  .hero-card .ic svg{width:22px;height:22px;color:var(--gold);}
  .svc .ic svg{width:26px;height:26px;color:var(--gold);}
  .about li .check svg{width:18px;height:18px;}
  .quote .stars{display:flex;gap:3px;margin-bottom:12px;}
  .quote .stars svg{width:16px;height:16px;color:var(--gold);}
  header.nav{position:sticky;top:0;z-index:50;background:rgba(11,11,11,.85);backdrop-filter:blur(10px);border-bottom:1px solid var(--border);}
  .nav-inner{display:flex;align-items:center;justify-content:space-between;height:72px;}
  .logo{display:flex;align-items:center;gap:10px;font-family:Georgia,serif;font-size:22px;font-weight:700;color:var(--ink);}
  .logo .mark{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--forest),var(--forest-2));display:grid;place-items:center;color:var(--gold);font-size:18px;}
  .nav-links{display:flex;gap:30px;align-items:center;}
  .nav-links a{text-decoration:none;color:var(--ink);font-size:15px;font-weight:500;}
  .nav-links a:hover{color:var(--gold);}
  .nav-links a.nav-cta{background:var(--gold);color:#141414;padding:10px 22px;border-radius:999px;font-size:14px;white-space:nowrap;}
  .nav-links a.nav-cta:hover{background:#E4C24E;color:#141414;}
  .burger{display:none;background:none;border:none;color:var(--gold);cursor:pointer;padding:0;}
  .burger .ic-close{display:none;}
  .burger.active .ic-menu{display:none;}
  .burger.active .ic-close{display:block;}
  .hero{position:relative;background:#0A0A0A;color:#fff;overflow:hidden;}
  .hero-bg{position:absolute;inset:0;z-index:0;background-image:url('https://images.unsplash.com/photo-1600334129128-685c5582fd35?auto=format&fit=crop&w=1600&q=80');background-size:cover;background-position:center;filter:blur(5px) brightness(.6);transform:scale(1.1);}
  .hero-overlay{position:absolute;inset:0;z-index:1;background:linear-gradient(135deg,rgba(8,8,8,.92) 0%,rgba(16,16,16,.74) 50%,rgba(20,20,20,.58) 100%);}
  .hero::after{content:"";position:absolute;right:-120px;top:-120px;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(201,162,75,.28),transparent 70%);z-index:1;}
  .hero::before{content:"";position:absolute;left:-80px;bottom:-140px;width:360px;height:360px;border-radius:50%;background:radial-gradient(circle,rgba(138,167,155,.25),transparent 70%);z-index:1;}
  .hero-inner{position:relative;z-index:2;display:grid;grid-template-columns:1.1fr .9fr;gap:50px;align-items:center;padding:90px 24px 100px;}
  .hero h1{font-size:52px;margin-bottom:22px;}
  .hero p.lead{font-size:18px;color:rgba(255,255,255,.85);max-width:520px;margin-bottom:32px;}
  .hero-actions{display:flex;gap:16px;flex-wrap:wrap;}
  .hero-card{background:rgba(20,20,20,.55);border:1px solid rgba(255,255,255,.16);border-radius:20px;padding:30px;backdrop-filter:blur(8px);}
  .hero-card h3{font-size:22px;color:var(--gold);margin-bottom:6px;}
  .hero-card .row{display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.12);}
  .hero-card .row:last-child{border-bottom:none;}
  .hero-card .ic{width:40px;height:40px;border-radius:10px;background:rgba(201,162,75,.2);display:grid;place-items:center;flex-shrink:0;}
  .hero-card .row div small{color:rgba(255,255,255,.7);font-size:13px;}
  section{padding:88px 0;}
  .section-head{text-align:center;max-width:640px;margin:0 auto 54px;}
  .section-head h2{font-size:38px;color:var(--ink);margin-bottom:14px;}
  .section-head p{color:var(--muted);font-size:17px;}
  .about{background:var(--cream);}
  .about-grid{display:grid;grid-template-columns:.85fr 1.15fr;gap:56px;align-items:center;}
  .about-slider{position:relative;aspect-ratio:4/5;border-radius:20px;overflow:hidden;box-shadow:var(--shadow);background:var(--forest);}
  .about-slider .slides{position:absolute;inset:0;}
  .about-slider .slide{position:absolute;inset:0;opacity:0;transition:opacity .8s ease;background-size:cover;background-position:center;}
  .about-slider .slide.active{opacity:1;}
  .about-slider .slide::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.05) 0%,rgba(0,0,0,.55) 100%);}
  .about-slider .badge{position:absolute;z-index:3;bottom:24px;left:24px;right:24px;background:rgba(18,18,18,.85);border:1px solid var(--border);border-radius:14px;padding:18px 20px;backdrop-filter:blur(4px);}
  .about-slider .badge strong{display:block;font-family:Georgia,serif;font-size:26px;color:var(--gold);}
  .about-slider .nav-arrow{position:absolute;z-index:4;top:50%;transform:translateY(-50%);width:42px;height:42px;border-radius:50%;border:none;background:rgba(18,18,18,.55);color:var(--gold);display:grid;place-items:center;cursor:pointer;transition:background .2s ease;}
  .about-slider .nav-arrow:hover{background:rgba(18,18,18,.9);}
  .about-slider .nav-arrow svg{width:22px;height:22px;}
  .about-slider .nav-arrow.prev{left:16px;}
  .about-slider .nav-arrow.next{right:16px;}
  .about-slider .dots{position:absolute;z-index:4;top:18px;left:0;right:0;display:flex;justify-content:center;gap:8px;}
  .about-slider .dots button{width:9px;height:9px;border-radius:50%;border:none;background:rgba(255,255,255,.45);cursor:pointer;padding:0;transition:background .2s ease,width .2s ease;}
  .about-slider .dots button.active{background:var(--gold);width:22px;border-radius:999px;}
  .about h2{font-size:34px;color:var(--ink);margin-bottom:20px;}
  .about p{color:var(--muted);margin-bottom:16px;}
  .about ul{list-style:none;margin-top:22px;display:grid;gap:14px;}
  .about li{display:flex;gap:12px;align-items:flex-start;}
  .about li .check{color:var(--gold);flex-shrink:0;margin-top:2px;}
  .stats{background:var(--forest);color:#fff;}
  .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:30px;text-align:center;}
  .stat .num{font-family:Georgia,serif;font-size:46px;color:var(--gold);line-height:1;}
  .stat .lbl{margin-top:10px;color:rgba(255,255,255,.8);font-size:15px;}
  .stats .section-head h2{color:#fff;}
  .services{background:var(--cream-2);}
  .svc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
  .svc{background:var(--white);border:1.5px solid var(--gold);border-radius:var(--radius);overflow:hidden;display:flex;flex-direction:column;opacity:0;transform:translateY(46px);transition:transform .6s cubic-bezier(.22,.61,.36,1), opacity .6s ease, box-shadow .2s ease, border-color .2s ease;box-shadow:0 0 0 1px rgba(212,175,55,.15);}
  .svc.reveal{opacity:1;transform:translateY(0);}
  .svc:hover{transform:translateY(-6px);box-shadow:0 0 0 1px rgba(212,175,55,.35), var(--shadow);border-color:var(--gold-2);}
  .svc:hover .svc-img{transform:scale(1.08);}
  .svc-img{position:relative;height:180px;background-size:cover;background-position:center;background-color:var(--forest);overflow:hidden;transition:transform .5s ease;}
  .svc-img::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,.05),rgba(11,11,11,.65));}
  .svc-body{padding:0 28px 28px;display:flex;flex-direction:column;flex:1;}
  .svc .ic{width:52px;height:52px;border-radius:12px;background:var(--gold-soft);border:1px solid var(--border);display:grid;place-items:center;margin:-26px 0 16px;position:relative;z-index:2;}
  .svc h4{font-size:20px;color:var(--gold);margin-bottom:8px;}
  .svc p{color:var(--muted);font-size:15px;margin-bottom:18px;}
  .svc-book{margin-top:auto;align-self:flex-start;display:inline-flex;align-items:center;gap:8px;background:var(--gold-soft);color:var(--gold);border:1px solid var(--border);padding:10px 20px;border-radius:999px;font-weight:700;font-size:14px;text-decoration:none;transition:background .2s ease,color .2s ease,border-color .2s ease;}
  .svc-book:hover{background:var(--gold);color:#20240F;border-color:var(--gold);}
  .svc-book svg{width:16px;height:16px;}
  .testi{background:var(--cream);}
  .testi-hint{display:none;text-align:center;color:var(--muted);font-size:13px;margin-top:16px;letter-spacing:.03em;}
  .testi-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;}
  .quote{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:30px;position:relative;}
  .quote p{font-style:italic;color:var(--ink);margin-bottom:18px;}
  .quote .who{display:flex;align-items:center;gap:12px;}
  .quote .av{width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,var(--gold),#8a6d1f);color:#141414;display:grid;place-items:center;font-family:Georgia,serif;font-weight:700;}
  .quote .who small{color:var(--muted);display:block;}
  .guide{background:var(--forest);color:#fff;}
  .guide .section-head h2{color:#fff;}
  .guide-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px 40px;max-width:920px;margin:0 auto;}
  .guide-item{display:flex;gap:14px;align-items:flex-start;padding:14px 0;border-bottom:1px solid rgba(255,255,255,.12);}
  .guide-item .n{width:30px;height:30px;border-radius:50%;background:rgba(201,162,75,.22);color:var(--gold);display:grid;place-items:center;font-weight:700;flex-shrink:0;font-size:14px;}
  .guide-item p{color:rgba(255,255,255,.85);font-size:15px;}
  .guide-note{text-align:center;margin-top:36px;color:var(--gold);font-size:15px;}
  .cta-band{background:linear-gradient(135deg,var(--gold),#B8892F);color:#20240F;text-align:center;}
  .cta-band h2{font-size:36px;margin-bottom:14px;color:#20240F;}
  .cta-band p{max-width:520px;margin:0 auto 28px;font-size:17px;color:#3a3410;}
  .cta-band .btn{background:var(--forest);color:#fff;}
  .cta-band .btn:hover{background:var(--forest-2);box-shadow:0 8px 22px rgba(15,61,62,.35);}
  footer{background:#050505;color:rgba(255,255,255,.8);padding:60px 0 30px;}
  footer a{color:rgba(255,255,255,.75);text-decoration:none;display:block;margin-bottom:10px;font-size:15px;}
  footer a:hover{color:var(--gold);}
  .foot-logo{display:flex;align-items:center;gap:10px;font-family:Georgia,serif;font-size:22px;color:#fff;margin-bottom:16px;}
  .foot-logo .mark{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--forest),var(--forest-2));display:grid;place-items:center;color:var(--gold);}
  .foot-bottom{border-top:1px solid rgba(255,255,255,.12);padding-top:24px;text-align:center;font-size:14px;color:rg