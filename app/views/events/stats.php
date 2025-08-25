<?php
$eventStats = $eventStats ?? [];
?>

<div class="container">
    <h2>Estadísticas de Participación</h2>
    
    <?php if (empty($eventStats)): ?>
        <p class="no-events">No hay eventos registrados.</p>
    <?php else: ?>
        <div class="stats-summary">
            <div class="summary-card">
                <h3>Total de Eventos</h3>
                <span class="stat-number"><?= count($eventStats) ?></span>
            </div>
            <div class="summary-card">
                <h3>Total de Inscritos</h3>
                <span class="stat-number"><?= array_sum(array_column($eventStats, 'inscritos')) ?></span>
            </div>
            <div class="summary-card">
                <h3>Promedio de Asistencia</h3>
                <span class="stat-number">
                    <?php 
                    $promedios = array_filter(array_column($eventStats, 'porcentaje_asistencia'), function($p) { return $p > 0; });
                    echo !empty($promedios) ? round(array_sum($promedios) / count($promedios), 1) . '%' : '0%';
                    ?>
                </span>
            </div>
        </div>

        <div class="stats-table">
            <table>
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Cupo</th>
                        <th>Inscritos</th>
                        <th>% Asistencia</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventStats as $stat): ?>
                        <tr>
                            <td>
                                <a href="?action=detail&id=<?= e($stat['id']) ?>" class="event-link">
                                    <?= e($stat['titulo']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="event-type <?= strtolower($stat['tipo']) ?>">
                                    <?= e($stat['tipo']) ?>
                                </span>
                            </td>
                            <td><?= e($stat['fecha']) ?></td>
                            <td><?= $stat['cupo'] > 0 ? $stat['cupo'] : 'Ilimitado' ?></td>
                            <td><?= $stat['inscritos'] ?></td>
                            <td>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= min($stat['porcentaje_asistencia'], 100) ?>%"></div>
                                    <span class="progress-text"><?= $stat['porcentaje_asistencia'] ?>%</span>
                                </div>
                            </td>
                            <td>
                                <?php if ($stat['cupo'] > 0 && $stat['inscritos'] >= $stat['cupo']): ?>
                                    <span class="status full">Lleno</span>
                                <?php elseif ($stat['inscritos'] > 0): ?>
                                    <span class="status active">Activo</span>
                                <?php else: ?>
                                    <span class="status empty">Sin inscritos</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <div class="actions">
        <a href="?action=index" class="btn btn-secondary">Volver a Eventos</a>
        <a href="?action=createForm" class="btn btn-primary">Crear Nuevo Evento</a>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.stats-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.summary-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #e9ecef;
}

.summary-card h3 {
    margin: 0 0 10px 0;
    color: #6c757d;
    font-size: 14px;
    text-transform: uppercase;
}

.stat-number {
    font-size: 2em;
    font-weight: bold;
    color: #4CAF50;
}

.stats-table {
    overflow-x: auto;
    margin-bottom: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
}

th {
    background-color: #f8f9fa;
    font-weight: bold;
    color: #495057;
}

.event-link {
    color: #4CAF50;
    text-decoration: none;
    font-weight: 500;
}

.event-link:hover {
    text-decoration: underline;
}

.event-type {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.event-type.limpieza {
    background-color: #e3f2fd;
    color: #1976d2;
}

.event-type.sembratón {
    background-color: #e8f5e8;
    color: #388e3c;
}

.event-type.minga {
    background-color: #fff3e0;
    color: #f57c00;
}

.progress-bar {
    position: relative;
    background-color: #e9ecef;
    border-radius: 10px;
    height: 20px;
    min-width: 80px;
}

.progress-fill {
    background-color: #4CAF50;
    height: 100%;
    border-radius: 10px;
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 11px;
    font-weight: bold;
    color: #333;
}

.status {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: bold;
    text-transform: uppercase;
}

.status.full {
    background-color: #ffebee;
    color: #c62828;
}

.status.active {
    background-color: #e8f5e8;
    color: #388e3c;
}

.status.empty {
    background-color: #f5f5f5;
    color: #757575;
}

.actions {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    font-size: 14px;
}

.btn-primary {
    background-color: #4CAF50;
    color: white;
}

.btn-primary:hover {
    background-color: #45a049;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.no-events {
    text-align: center;
    color: #6c757d;
    font-style: italic;
    margin: 40px 0;
}

@media (max-width: 768px) {
    .stats-summary {
        grid-template-columns: 1fr;
    }
    
    table {
        font-size: 14px;
    }
    
    th, td {
        padding: 8px;
    }
    
    .actions {
        flex-direction: column;
    }
}
</style>

