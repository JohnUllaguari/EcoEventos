<?php // app/views/layout/header.php ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>EcoEventos CSV</title>
  <style>
    body{font-family:system-ui,Arial,sans-serif;margin:2rem;background:#f6f7f9;color:#1f2937}
    header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}
    .btn{padding:.6rem 1rem;border:1px solid #10b981;background:#10b981;color:white;border-radius:8px;cursor:pointer;text-decoration:none}
    .btn.sec{background:white;color:#10b981}
    .card{background:white;border:1px solid #e5e7eb;border-radius:12px;padding:1rem;margin:.5rem 0}
    input,select,textarea{padding:.5rem;border:1px solid #d1d5db;border-radius:6px;width:100%}
    form.grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
    form.grid .full{grid-column:1 / -1}
  </style>
</head>
<body>
<header>
  <h1>EcoEventos (PHP + CSV)</h1>
  <div>
    <a href="?action=index" class="btn sec">Eventos</a>
    <a href="?action=createForm" class="btn">Crear Evento</a>
  </div>
</header>
