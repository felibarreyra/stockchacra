<div class="registrar-consumo-container">
  <h2>🍽 Registrar Consumo de Productos</h2>
  <?php function mostrarDecimalLimpio($num) {
    return rtrim(rtrim(number_format($num, 2, '.', ''), '0'), '.');
  } ?>

  <!-- Filtro por área -->
  <form method="GET" action="" class="form-filtro-area">
    <input type="hidden" name="seccion" value="formulario_consumo">
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

  <!-- Formulario de consumo -->
<form method="POST" action="index.php?seccion=guardar_consumo" class="form-consumo">
  <label for="busqueda">Buscar producto:</label>
  <input type="text" id="busqueda" placeholder="Escribí el nombre del producto..." onkeyup="filtrarProductos()">

  <label for="id_producto">Producto:</label>
  <select name="id_producto" id="id_producto" required>
    <option value="">-- Seleccione --</option>
    <?php foreach ($productos as $producto): ?>
      <option value="<?= $producto['id'] ?>">
        <?= htmlspecialchars($producto['nombre']) ?> (Stock: <?= mostrarDecimalLimpio($producto['cantidad_actual']) ?>)
      </option>
    <?php endforeach; ?>
  </select>

  <label for="cantidad">Cantidad Consumida:</label>
  <input type="number" name="cantidad" id="cantidad" min="0.01" step="0.01" required>

  <!-- ✅ NUEVO: Fecha real del consumo -->
  <label for="fecha_consumo">Fecha del consumo:</label>
  <input type="date" name="fecha_consumo" id="fecha_consumo" value="<?= date('Y-m-d', strtotime('last saturday')) ?>" required>

  <button type="submit">➖ Registrar Consumo</button>
</form>

</div>

<script>
function filtrarProductos() {
    const filtro = document.getElementById("busqueda").value.toLowerCase();
    const select = document.getElementById("id_producto");
    const opciones = select.options;

    for (let i = 0; i < opciones.length; i++) {
        const texto = opciones[i].text.toLowerCase();
        opciones[i].style.display = texto.includes(filtro) ? "" : "none";
    }
}
</script>

