<?php
$event = $event ?? null;
if (!$event) {
    echo "<p>Error: Evento no encontrado</p>";
    return;
}
?>

<div class="container">
    <h2>Actualizar Evento</h2>
    
    <form method="POST" action="?action=updateSubmit&id=<?= e($event['id']) ?>">
        <div class="form-group">
            <label for="titulo">Título del Evento *</label>
            <input type="text" id="titulo" name="titulo" value="<?= e($event['titulo']) ?>" required>
        </div>

        <div class="form-group">
            <label for="tipo">Tipo de Evento *</label>
            <select id="tipo" name="tipo" required>
                <option value="Limpieza" <?= ($event['tipo'] === 'Limpieza') ? 'selected' : '' ?>>Limpieza</option>
                <option value="Sembratón" <?= ($event['tipo'] === 'Sembratón') ? 'selected' : '' ?>>Sembratón</option>
                <option value="Minga" <?= ($event['tipo'] === 'Minga') ? 'selected' : '' ?>>Minga</option>
            </select>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="fecha">Fecha *</label>
                <input type="date" id="fecha" name="fecha" value="<?= e($event['fecha']) ?>" required>
            </div>
            <div class="form-group">
                <label for="hora">Hora</label>
                <input type="time" id="hora" name="hora" value="<?= e($event['hora']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación *</label>
            <input type="text" id="ubicacion" name="ubicacion" value="<?= e($event['ubicacion']) ?>" required>
        </div>

        <div class="form-group">
            <label for="cupo">Cupo de Participantes</label>
            <input type="number" id="cupo" name="cupo" value="<?= e($event['cupo']) ?>" min="0" placeholder="0 = ilimitado">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3"><?= e($event['descripcion']) ?></textarea>
        </div>

        <div class="form-group">
            <label for="detalle">Detalles Adicionales</label>
            <textarea id="detalle" name="detalle" rows="4"><?= e($event['detalle']) ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
            <a href="?action=detail&id=<?= e($event['id']) ?>" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<style>
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-row .form-group {
    flex: 1;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

input:focus, select:focus, textarea:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.3);
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 30px;
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
</style>

