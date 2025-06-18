<?php
require_once __DIR__ . '/../models/modelproducto.php';
date_default_timezone_set('America/Argentina/Buenos_Aires');

class StockController {
    public function stockActual() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $id_area = $_GET['id_area'] ?? null;
    
        if ($id_area) {
            $productos = $productoModel->obtenerProductosPorArea($id_area);
            $areaSeleccionada = $productoModel->obtenerNombreArea($id_area);
        } else {
            $productos = $productoModel->obtenerStockPorArea();
            $areaSeleccionada = null;
        }
    
        $areas = $productoModel->obtenerAreas();
        include __DIR__ . '/../views/stock/actual.php';
    }
    public function formularioConsumo() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $id_area = $_GET['id_area'] ?? null;
    
        if ($id_area) {
            $productos = $productoModel->obtenerProductosPorArea($id_area);
        } else {
            $productos = $productoModel->obtenerStockPorArea();
        }
    
        $areas = $productoModel->obtenerAreas();
        include __DIR__ . '/../views/consumo/formulario_consumo.php';
    }
    
    public function guardarConsumo() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $producto_id = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha_consumo'] ?? date('Y-m-d');

    
        if ($cantidad <= 0) {
            echo "<p style='color:red; text-align:center;'>❗ Cantidad inválida.</p>";
            return;
        }
    
        // Obtener el stock actual del producto
        $producto = $productoModel->obtenerProductoPorId($producto_id);
    
        if (!$producto) {
            echo "<p style='color:red; text-align:center;'>❗ Producto no encontrado.</p>";
            return;
        }
    
        if ($producto['cantidad_actual'] < $cantidad) {
            echo "<p style='color:red; text-align:center;'>❗ No hay suficiente stock disponible.</p>";
            return;
        }
    
        // Registrar consumo
        $productoModel->registrarConsumo($producto_id, $fecha, $cantidad);
    
        // Restar del stock
        $productoModel->restarStock($producto_id, $cantidad);
    
        echo "<p style='color:green; text-align:center;'>✅ Consumo registrado y stock actualizado.</p>";
    }
    
    public function verConsumos() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $fecha_sabado = $_GET['fecha_sabado'] ?? null;
        $id_area = $_GET['id_area'] ?? null;
    
        $consumos = $productoModel->obtenerConsumosFiltrados($fecha_sabado, $id_area);
        $areas = $productoModel->obtenerAreas();
    
        include __DIR__ . '/../views/consumo/ver_consumos.php';
    }
    
    public function formularioAgregarProducto() {
        global $pdo;
        $productoModel = new Producto($pdo);
        $areas = $productoModel->obtenerAreas();
        require 'views/stock/formulario_agregar_producto.php';
    }
    
    public function guardarNuevoProducto() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $nombre = $_POST['nombre'];
        $unidad = $_POST['unidad'];
        $cantidad = $_POST['cantidad'];
        $gasto = $_POST['gasto_x_sabado'];
        $id_area = $_POST['id_area'];
    
        if ($productoModel->agregarProducto($nombre, $unidad, $cantidad, $gasto, $id_area)) {
            echo "<p style='color:green; text-align:center;'>✅ Producto agregado correctamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>❗ Error al agregar el producto.</p>";
        }
    }

    public function formularioAgregarArea() {
        require 'views/stock/formulario_agregar_area.php';
    }
    
    public function guardarNuevaArea() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $nombre = $_POST['nombre'];
    
        if ($productoModel->agregarArea($nombre)) {
            echo "<p style='color:green; text-align:center;'>✅ Área agregada correctamente.</p>";
        } else {
            echo "<p style='color:red; text-align:center;'>❗ Error al agregar el área.</p>";
        }
    }

    public function eliminarProducto() {
        global $pdo;
        $productoModel = new Producto($pdo);
    
        $id_producto = $_POST['id_producto'] ?? null;
    
        if ($id_producto) {
            if ($productoModel->eliminarProducto($id_producto)) {
                echo "<p style='color:green; text-align:center;'>✅ Producto eliminado correctamente.</p>";
            } else {
                echo "<p style='color:red; text-align:center;'>❗ Error al eliminar el producto.</p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>❗ ID de producto no proporcionado.</p>";
        }
    }
    
    
    
    
}
