<div class="agregar-pedido-container">
  <h1 class="ver-pedidos-title">📦 Registrar Llegada de Pedido</h1>
  <?php if (isset($_GET['exito'])): ?>
  <div class="alert success">
    ✅ Pedido recibido y stock actualizado correctamente.
  </div>
<?php endif; ?>


  <form method="POST" action="index.php?seccion=agregar_pedido">
    <label for="id_pedido">Seleccionar pedido pendiente:</label>
    <select name="id_pedido" id="id_pedido" required>
      <option value="">-- Seleccione --</option>
      <?php foreach ($pedidosPendientes as $pedido): ?>
        <option value="<?= $pedido['id'] ?>" <?= ($pedidoSeleccionado == $pedido['id']) ? 'selected' : '' ?>>
          <?= $pedido['nro_remito'] ?> - <?= $pedido['fecha'] ?>
        </option>
      <?php endforeach; ?>
    </select>
    <button type="submit" name="buscar">🔍 Ver Detalle</button>
  </form>

  <?php function mostrarDecimalLimpio($num) {
    return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.');
  } ?>

  <?php if (isset($detalle)): ?>
    <form method="POST" action="index.php?seccion=guardar_recepcion">
      <input type="hidden" name="id_pedido" value="<?= $pedidoSeleccionado ?>">

      <!-- Contenedor con scroll -->
      <div class="tabla-recibir-scroll">
        <table class="tabla-pedidos">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Pedido</th>
              <th>Recibido</th>
              <th>Pago</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($detalle as $item): ?>
              <tr>
                <td><?= htmlspecialchars($item['nombre']) ?></td>
                <td><?= mostrarDecimalLimpio($item['cantidad_pedida']) ?></td>
                <td>
                  <input type="number" name="recibido[<?= $item['id_producto'] ?>]" min="0" step="0.01" value="<?= mostrarDecimalLimpio($item['cantidad_pedida']) ?>">
                  <td style="text-align: center;">
                    <?php if ($item['fue_pagado'] == 1): ?>
                        <input type="checkbox" checked disabled>
                        <input type="hidden" name="pagado[<?= $item['id_producto'] ?>]" value="1">
                    <?php else: ?>
                        <input type="checkbox" name="pagado[<?= $item['id_producto'] ?>]" value="1">
                    <?php endif; ?>
                    </td>

              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <button type="submit" class="pedido-submit">✅ Confirmar Recepción</button>
    </form>
  <?php endif; ?>
</div>

