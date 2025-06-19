<?php
function mostrarDecimalLimpio($num) {
    return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.');
}
?>

<div class="consumos-container">
  <h1>📊 Consumos Registrados</h1>

  <!-- Filtro por sábado y área -->
  <form method="GET" class="form-filtro-area">
    <input type="hidden" name="seccion" value="ver_consumos">

    <label for="fecha_sabado">Filtrar por sábado:</label>
    <input type="date" name="fecha_sabado" id="fecha_sabado" value="<?= $_GET['fecha_sabado'] ?? date('Y-m-d', strtotime('last saturday')) ?>">

    <label for="id_area">Filtrar por área:</label>
    <select name="id_area" id="id_area">
      <option value="">-- Todas --</option>
      <?php foreach ($areas as $a): ?>
        <option value="<?= $a['id'] ?>" <?= (isset($_GET['id_area']) && $_GET['id_area'] == $a['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($a['nombre']) ?>
        </option>
      <?php endforeach; ?>
    </select>

    <button type="submit">Filtrar</button>
  </form>

  <?php if (empty($consumos)): ?>
    <p>No hay consumos registrados<?= isset($_GET['fecha_sabado']) ? ' para esa fecha.' : ' aún.' ?></p>
  <?php else: ?>
    <div class="tabla-consumo-scroll">
      <table class="tabla-consumos">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Eliminar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($consumos as $consumo): ?>
            <tr>
              <td data-label="Producto"><?= htmlspecialchars($consumo['nombre_producto'] ?? $consumo['nombre']) ?></td>
              <td data-label="Fecha"><?= htmlspecialchars($consumo['fecha']) ?></td>
              <td data-label="Cantidad"><?= mostrarDecimalLimpio($consumo['cantidad']) ?></td>
              <td data-label="Eliminar">
                <form method="POST" action="index.php?seccion=eliminar_consumo"
                      onsubmit="return confirm('¿Estás seguro de eliminar este consumo? Esta acción no se puede deshacer.');"
                      style="display:inline;">
                  <input type="hidden" name="id_consumo" value="<?= $consumo['id'] ?>">
                  <button type="submit" class="btn-eliminar-p" title="Eliminar Consumo">🗑️</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

