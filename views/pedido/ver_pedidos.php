<?php
// Agrupamos por id_pedido
$agrupados = [];

foreach ($pedidos as $fila) {
    $id = $fila['id_pedido'];
    if (!isset($agrupados[$id])) {
        $agrupados[$id] = [
            'nro_remito' => $fila['nro_remito'],
            'fecha' => $fila['fecha'],
            'estado' => $fila['estado'],
            'productos' => []
        ];
    }

    $agrupados[$id]['productos'][] = [
        'nombre_producto' => $fila['nombre_producto'],
        'cantidad_pedida' => $fila['cantidad_pedida'],
        'cantidad_recibida' => $fila['cantidad_recibida'],
        'cantidad_actual' => $fila['cantidad_actual'],
        'fue_pagado' => $fila['fue_pagado'],
        'id_producto' => $fila['id_producto']
    ];
}
?>

<div class="ver-pedidos-container">
  <h1 class="ver-pedidos-title">📋 Pedidos Generados</h1>
  <?php 
  function mostrarDecimalLimpio($num) {
      return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.');
  }
  ?>
  <?php if (empty($pedidos)): ?>
    <p class="ver-pedidos-msg">No hay pedidos generados aún.</p>
  <?php else: ?>
    <div class="tabla-scroll">
      <table class="tabla-pedidos">
        <thead>
          <tr>
            <th>#</th>
            <th>Remito</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th colspan="5" style="background-color:#3d7424; color:white; padding: 10px; font-size: 1rem; text-align: center;">
              📦 DETALLE DEL PEDIDO
            </th>
            <th>Eliminar</th>
            <th>Descargar</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($agrupados as $id => $pedido): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= htmlspecialchars($pedido['nro_remito']) ?></td>
              <td><?= htmlspecialchars($pedido['fecha']) ?></td>
              <td class="<?= $pedido['estado'] === 'Pendiente' ? 'estado-pendiente' : 'estado-recibido' ?>">
                <?= htmlspecialchars($pedido['estado']) ?>
              </td>
              <td colspan="5">
                <table class="tabla-pedidos-interna">
                  <thead>
                    <tr>
                      <th>Producto</th>
                      <th>Pedido</th>
                      <th>Recibido</th>
                      <th>Stock</th>
                      <th>Pagado</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pedido['productos'] as $prod): ?>
                      <tr>
                        <td><?= htmlspecialchars($prod['nombre_producto']) ?></td>
                        <td><?= mostrarDecimalLimpio($prod['cantidad_pedida']) ?></td>
                        <td><?= mostrarDecimalLimpio($prod['cantidad_recibida']) ?></td>
                        <td><?= mostrarDecimalLimpio($prod['cantidad_actual']) ?></td>
                        <td>
                          <?php if ($prod['fue_pagado']): ?>
                            ✅
                          <?php else: ?>
                            ❌
                            <form method="POST" action="index.php?seccion=marcar_pagado" style="display:inline;">
                              <input type="hidden" name="id_pedido" value="<?= $id ?>">
                              <input type="hidden" name="id_producto" value="<?= $prod['id_producto'] ?>">
                              <button type="submit" class="btn-pagar" title="Marcar como pagado">💰</button>
                            </form>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </td>
              <td>
                <form method="POST" action="index.php?seccion=eliminar_pedido"
                      onsubmit="return confirm('¿Estás seguro de eliminar este pedido? Esta acción no se puede deshacer.');"
                      style="display:inline;">
                  <input type="hidden" name="id_pedido" value="<?= $id ?>">
                  <button type="submit" class="btn-eliminar-p" title="Eliminar Pedido">🗑️</button>
                </form>
              </td>
              <td>
              <a href="generar_pedido_pdf.php?id_pedido=<?= $id ?>" 
                class="btn-descargar" 
                target="_blank">
                📄 Descargar PDF
              </a>
            </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

