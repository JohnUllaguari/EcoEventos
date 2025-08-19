  <?php // app/views/layout/header.php ?>
  <!doctype html>
  <html lang="es">
  <head>
    <meta charset="utf-8">
    <title>EcoEventos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
      :root{
        --green-600:#16a34a; --green-700:#15803d;
        --text:#1f2937; --muted:#475569; --bg:#f6f7f9; --white:#fff;
        --shadow:0 8px 24px rgba(2,6,23,.08);
      }
      *{box-sizing:border-box}
      body{margin:0;background:var(--bg);color:var(--text);font:16px/1.5 "Inter",system-ui,Arial}
      .container{width:min(1100px,92%);margin:auto}

      /* NAVBAR */
      .navbar{position:sticky;top:0;z-index:50;background:rgba(255,255,255,.85);
        border-bottom:1px solid rgba(0,0,0,.06);backdrop-filter:saturate(140%) blur(8px);}
      .navbar .row{display:flex;align-items:center;gap:14px;padding:10px 0;}
      .brand{display:flex;align-items:center;gap:10px;text-decoration:none;color:#0f172a;font-weight:700}
      .brand svg{flex:0 0 auto}
      .nav-links{display:flex;gap:18px;margin-left:auto;list-style:none;padding:0}
      .nav-links a{color:var(--muted);text-decoration:none;padding:10px 4px}
      .nav-links a:hover{color:#0f172a}
      .btn{display:inline-block;padding:.6rem 1rem;border-radius:10px;text-decoration:none;border:1px solid var(--green-600)}
      .btn.sec{background:var(--white);color:var(--green-600)}
      .btn.pri{background:var(--green-600);color:var(--white);box-shadow:var(--shadow)}
      .btn.pri:hover{background:var(--green-700)}
      .hello{color:var(--muted);font-size:.95rem}

      /* HERO */
      .hero{position:relative;isolation:isolate;min-height:230px;display:grid;align-items:center}
      .hero.bg{
        background:url('https://images.unsplash.com/photo-1461354464878-ad92f492a5a0?q=80&w=1600&auto=format&fit=crop') center/cover no-repeat;
      }
      .hero::before{content:"";position:absolute;inset:0;z-index:-1;
        background:linear-gradient(180deg, rgba(22,163,74,.70), rgba(21,128,61,.70));}
      .hero .content{padding:40px 0;color:white;text-align:center}
      .hero h1{margin:0 0 6px;font-size:44px;letter-spacing:.5px}
      .hero p{margin:0 0 6px;font-size:18px;opacity:.95}
      .hero small{opacity:.9}

      /* Tarjetas / formularios (tu estilo original) */
      .card{background:white;border:1px solid #e5e7eb;border-radius:12px;padding:1rem;margin:.5rem 0}
      input,select,textarea{padding:.5rem;border:1px solid #d1d5db;border-radius:6px;width:100%}
      form.grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
      form.grid .full{grid-column:1 / -1}

      /* Móvil */
      .nav-toggle{display:none;margin-left:auto;background:none;border:0;padding:8px}
      .nav-toggle span{display:block;width:22px;height:2px;margin:5px 0;background:#0f172a}
      @media (max-width:900px){
        .nav-links{display:none}
        .nav-toggle{display:block}
        .navbar.open .nav-links{
          display:flex;position:absolute;left:0;right:0;top:56px;background:white;
          flex-direction:column;gap:0;padding:6px 16px 12px;border-bottom:1px solid rgba(0,0,0,.06)
        }
        .navbar.open .nav-links a{padding:12px 0}
        .hero h1{font-size:32px}
        .hero{min-height:200px}
      }
    </style>
  </head>
  <body data-page="<?php echo e($PAGE ?? ''); ?>">

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="container row">
      <a class="brand" href="?action=index" aria-label="EcoEventos">
        <svg width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
          <circle cx="12" cy="12" r="11" fill="#16a34a"/>
          <path d="M7 13c3-1 4-4 5-7 2 4 4 6 5 7-2 2-4 4-5 7-1-3-2-5-5-7z" fill="white"/>
        </svg>
        <span>EcoEventos</span>
      </a>

      <button class="nav-toggle" aria-label="Abrir menú" aria-expanded="false"><span></span><span></span><span></span></button>

      <ul class="nav-links">
        <li><a href="?action=index">Eventos</a></li>
        <?php if (current_user()) { ?>
          <li><a href="?action=myEvents">Mis eventos</a></li>
        <?php } ?>
      </ul>

      <?php if (current_user()) { ?>
        <span class="hello">Hola, <?php echo e(current_user()['nombre']); ?></span>
        <a href="?action=createForm" class="btn pri">+ Crear Evento</a>
        <a href="?action=logout" class="btn sec">Salir</a>
      <?php } else { ?>
        <a href="?action=loginForm" class="btn sec">Ingresar</a>
        <a href="?action=registerForm" class="btn pri">Registrarse</a>
      <?php } ?>
    </div>
  </nav>

  <!-- HERO (solo en la página principal; en otras puedes omitirlo) -->
  <?php
    // Muestra el hero si NO estamos en formularios o páginas internas
    $isHome = !isset($_GET['action']) || ($_GET['action'] ?? 'index') === 'index';
    if ($isHome):
  ?>
  <section class="hero bg">
    <div class="container content">
      <h1>EcoEventos</h1>
      <p>Conecta, participa y transforma tu comunidad</p>
      <small>Únete a mingas, sembratones y eventos sostenibles que hacen la diferencia</small>
    </div>
  </section>
  <?php endif; ?>

  <script>
    // Menú móvil
    const nav = document.querySelector('.navbar');
    const btn = document.querySelector('.nav-toggle');
    if (btn){ btn.addEventListener('click', ()=> {
      const open = nav.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }); }
  </script>
