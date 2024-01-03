<fieldset>
    <legend>Información Personal</legend>
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" placeholder="Nombre del Vendedor" value="<?php echo s($vendedor->nombre); ?>">
    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="apellido" placeholder="Apellido del Vendedor" value="<?php echo s($vendedor->apellido); ?>">
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" placeholder="Número de Teléfono" value="<?php echo s($vendedor->telefono); ?>">
</fieldset>