<?php
/*
Plugin Name: Configurador de Páginas Web
Description: Un plugin para seleccionar características de una página web y calcular el precio total.
Version: 1.1
Author: Llobregat Digital
*/

// Evitar acceso directo al archivo
if (!defined('ABSPATH')) {
    exit;
}

// Registrar los estilos del plugin
function mi_plugin_lista_estilos() {
    wp_enqueue_style('mi-plugin-lista-css', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'mi_plugin_lista_estilos');

// Registrar el shortcode
function mi_lista_productos_shortcode() {
    ob_start(); ?>
    <div id="mi-lista-productos">
        <h3>Configura tu Página Web</h3>
        <div class="productos-grid">
            <label class="item"><input type="checkbox" class="producto" data-precio="30"> Páginas legales</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="500"> Diseño personalizado</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="1000"> Tienda online (E-commerce)</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="200"> Optimización SEO básica</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="300"> Blog</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="150"> Integración con redes sociales</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="400"> Sistema de reservas</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="250"> Formularios de contacto avanzados</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="600"> Multilenguaje</label>
            <label class="item"><input type="checkbox" class="producto" data-precio="350"> Hosting y dominio por un año</label>
        </div>
        
        <div class="opciones">
            <label>Número de páginas extra (100€/página): 
                <select id="num-paginas">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </label>
        </div>

        <div class="opciones" id="productos-extra" style="display: none;">
            <label>Número de productos para E-commerce (10€/producto): 
                <select id="num-productos">
                    <option value="0">0</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
            </label>
        </div>
        
        <div class="opciones">
            <label>Número de imágenes personalizadas (5€/imagen): 
                <select id="num-imagenes">
                    <option value="0">0</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                </select>
            </label>
        </div>

        <button id="calcular-total">Calcular Precio</button>
        <p id="total-container" style="display: none; font-size: 24px; color: green; font-weight: bold;">Total: <span id="precio-total">0</span>€</p>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("calcular-total").addEventListener("click", function() {
                let total = 0;
                
                document.querySelectorAll(".producto:checked").forEach(function(checkbox) {
                    total += parseFloat(checkbox.getAttribute("data-precio"));
                });
                
                let numPaginas = parseInt(document.getElementById("num-paginas").value);
                total += numPaginas * 100;
                
                let numImagenes = parseInt(document.getElementById("num-imagenes").value);
                total += numImagenes * 5;
                
                let ecommerceCheckbox = document.querySelector("input[data-precio='1000']");
                if (ecommerceCheckbox.checked) {
                    document.getElementById("productos-extra").style.display = "block";
                    let numProductos = parseInt(document.getElementById("num-productos").value);
                    total += numProductos * 10;
                } else {
                    document.getElementById("productos-extra").style.display = "none";
                }
                
                document.getElementById("precio-total").textContent = total;
                document.getElementById("total-container").style.display = "block";
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('mi_lista_productos', 'mi_lista_productos_shortcode');