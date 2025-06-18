<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Stock Actual</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
function mostrarDecimalLimpio($num) {
    return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.');
}
?>

<div class="stock-actual-container">
    <h1>📦 Stock Actual <?= isset($areaSeleccionada) ? "– Área: $areaSeleccionada" : "" ?></h1>

    <form method="GET" action="" class="stock-filter-form">
        <input type="hidden" name="seccion" value="stock">
        <label for="id_area">Filtrar por área:</label>
        <select name="id_area" id="id_area" onchange="this.form.submit()">
            <option value="">-- Todas --</option>
            <?php foreach ($areas as $a): ?>
                <option value="<?= $a['id'] ?>" <?= (isset($_GET['id_area']) && $_GET['id_area'] == $a['id']) ? 'selected' : '' ?>>
                    <?= $a['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Contenedor para scroll vertical -->
    <div class="stock-scroll">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
                    <th>Gasto por Sábado</th>
                    <th>Últ. Fecha Ingreso</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td data-label="Producto"><?= htmlspecialchars($p['nombre']) ?></td>
                        <td data-label="Unidad"><?= htmlspecialchars($p['unidad_medida']) ?></td>
                        <?php
                        $cantidad = $p['cantidad_actual'];
                        $gasto = $p['gasto_x_sabado'];
                        $alertaStock = ($cantidad < $gasto);
                        $diferencia = round($gasto - $cantidad, 2);
                        ?>
                        <td class="<?= $alertaStock ? 'stock-alerta tooltip' : 'stock-ok tooltip' ?>">
                            <?= mostrarDecimalLimpio($cantidad) ?>
                            <?= $alertaStock ? ' 🔴' : ' ✅' ?>
                            <span class="tooltip-text">
                                <?= $alertaStock
                                    ? "⚠ Faltan $diferencia unidades para cubrir el sábado"
                                    : "✔ Stock suficiente para el próximo sábado" ?>
                            </span>
                        </td>
                        <td data-label="Gasto por Sábado"><?= mostrarDecimalLimpio($p['gasto_x_sabado']) ?></td>
                        <td data-label="Fecha Ingreso"><?= isset($p['fecha_ingreso']) ? htmlspecialchars($p['fecha_ingreso']) : 'N/D' ?></td>
                        <td>
                        <form method="POST" action="index.php?seccion=eliminar_producto"
                            onsubmit="return confirm('¿Estás seguro de eliminar este producto? Esta acción no se puede deshacer.');"
                            style="display:inline;">
                            <input type="hidden" name="id_producto" value="<?= $p['id'] ?>">
                            <button type="submit" class="btn-eliminar-pro" title="Eliminar Producto">🗑️</button>
                        </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
