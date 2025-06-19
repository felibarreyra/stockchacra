

<div class="contenedor-agregar-producto">
  <h2 class="form-titulo">➕ Agregar Nuevo Producto</h2>
      <?php if (isset($_GET['success'])): ?>
      <div class="alert success">✅ Producto agregado correctamente.</div>
    <?php elseif (isset($_GET['error'])): ?>
      <div class="alert error">❌ Error al agregar el producto.</div>
    <?php endif; ?>

  <form method="POST" action="index.php?seccion=guardar_nuevo_producto" class="form-agregar-producto">
    <label class="form-label">Nombre:</label>
    <input type="text" name="nombre" required class="form-input">

    <label class="form-label">Unidad de Medida:</label>
    <input type="text" name="unidad" required class="form-input">

    <label class="form-label">Cantidad Inicial:</label>
    <input type="number" step="0.01" name="cantidad" required class="form-input">

    <label class="form-label">Gasto por Sábado:</label>
    <input type="number" step="0.01" name="gasto_x_sabado" required class="form-input">

    <label class="form-label">Área:</label>
    <select name="id_area" required class="form-select">
      <option value="">-- Seleccione un área --</option>
      <?php foreach ($areas as $area): ?>
        <option value="<?= $area['id'] ?>"><?= htmlspecialchars($area['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <button type="submit" class="form-btn-submit">✅ Guardar Producto</button>
  </form>
</div>


