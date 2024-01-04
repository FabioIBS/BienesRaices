<main class="contenedor">
    <h1>Contacto</h1>
    <picture>
        <source srcset="build/img/destacada3.webp" type="img/webp">
        <source srcset="build/img/destacada3.jpg" type="img/jpeg">
        <img src="build/img/destacada3.jpg" alt="Imagen Contacto" loading="lazy">
    </picture>
    <h2>Llene el formulario de contacto</h2>
    <form class="formulario" action="/contacto" method="POST">
        <fieldset>
            <legend>Información Personal</legend>

            <label for="nombre">Nombre:</label>
            <input id="nombre" type="text" name="nombre" required placeholder="Tu Nombre">

            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" name="mensaje" required type="text" placeholder="Tu Nombre"></textarea>

        </fieldset>
        <fieldset>
            <legend>Información sobre la propiedad</legend>
            <label for="Tipo">Vende o Compra:</label>
            <select required name="compra_venta" id="opciones">
                <option value="" disabled selected>Seleccione</option>
                <option value="venta">Vende</option>
                <option value="compra">Compra</option>
            </select>
            <label for="presupuesto">Precio o Presupuesto:</label>
            <input id="presupuesto" required name="precio" type="number" placeholder="Tu Precio o Presupuesto">
        </fieldset>
        <fieldset>
            <legend>Información de contacto</legend>
            <p>Como desea ser contactado</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Teléfono:</label>
                <input required name="contacto" value="telefono" type="radio" id="contactar-telefono">
                <label for="contactar-email">E-mail:</label>
                <input required name="contacto" value="email" type="radio" id="contactar-email">
            </div>
            <div id="contacto"></div>
        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde">
    </form>
</main>