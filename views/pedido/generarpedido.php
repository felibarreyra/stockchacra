<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generar Pedido Manual</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
function mostrarDecimalLimpio($num) {
    return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.');
}
?>

<div class="pedido-form-container">
    <h1>📝 Pedido <?= $areaSeleccionada ? "– Área: $areaSeleccionada" : "" ?></h1>
    <?php if (isset($_GET['success']) && $_GET['remito']): ?>
        <div class="alert success">
            ✅ Pedido generado correctamente – Remito: <strong><?= htmlspecialchars($_GET['remito']) ?></strong>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert error">
            ❌ <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    

    <form action="index.php?seccion=guardar_pedido_manual" method="POST" class="pedido-form">

        <!-- Contenedor para el scroll -->
        <div class="pedido-scroll">
            <table class="pedido">
                <thead>
                    <tr>
                        <th class="pedido">Producto</th>
                        <th class="pedido">Unidad</th>
                        <th class="pedido">Stock</th>
                        <th class="pedido">Gasto por Sábado</th>
                        <th class="pedido">Cantidad a Pedir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                        <tr class="pedido">
                            <td class="pedido"><?= htmlspecialchars($p['nombre']) ?></td>
                            <td class="pedido"><?= htmlspecialchars($p['unidad_medida']) ?></td>
                            <td class="pedido">
                                <?php if ($p['cantidad_actual'] < $p['gasto_x_sabado']): ?>
                                    <span class="stock-alerta tooltip">
                                        <?= mostrarDecimalLimpio($p['cantidad_actual']) ?> 🔴
                                        <span class="tooltip-text">
                                            ⚠ Faltan <?= mostrarDecimalLimpio(round($p['gasto_x_sabado'] - $p['cantidad_actual'], 2)) ?> unidades para cubrir el sábado
                                        </span>
                                    </span>
                                <?php else: ?>
                                    <span class="stock-ok tooltip">
                                        <?= mostrarDecimalLimpio($p['cantidad_actual']) ?> ✅
                                        <span class="tooltip-text">✔ Stock suficiente para el próximo sábado</span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="pedido"><?= mostrarDecimalLimpio($p['gasto_x_sabado']) ?></td>
                            <td class="pedido">
                                <input type="number" name="productos[<?= $p['id'] ?>]" min="0" value="0" class="pedido-cantidad">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="form-footer">
            <button type="submit" class="pedido-submit">✅ Generar Pedido</button>
        </div>
    </form>

    <form method="GET" action="" class="pedido-filtro">
        <input type="hidden" name="seccion" value="formulario_pedido_manual">
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
</div>
</body>
</html>
