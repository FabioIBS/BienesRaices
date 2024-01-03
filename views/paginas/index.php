<main class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>

    <?php include 'iconos.php' ?>

</main>
<section class="seccion contenedor">
    <h2>Casas y Departamentos en Venta</h2>

    <?php
    include 'listado.php';
    ?>

    <div class="alinear-derecha">
        <a href="/anuncios" class="boton-verde">Ver Todas...</a>
    </div>
</section><!-- Anuncios -->
<section class="contacto-imagen">
    <h2>Encuentra la casa de tus sueños</h2>
    <p>Llena el formulario y un asesor se pondrá en contacto a la brevedad.</p>
    <a href="contacto" class="boton-amarillo">Contáctanos</a>
</section>
<div class="contenedor seccion seccion-inferior">
    <section class="blog">
        <h2>Nuestro Blog</h2>
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="img/webp">
                    <source srcset="build/img/blog1.jpg" type="img/jpeg">
                    <img src="build/img/blog1.jpg" alt="Texto Entrada Blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p class="informacion-meta">Escrito el: <span>20/10/2023</span> Por: <span>Admin</span></p>
                    <p>Consejos para construir una terraza en el techo de tu casa con los mejores materiales y
                        ahorrando dinero.</p>
                </a>
            </div>
        </article>
        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog2.webp" type="img/webp">
                    <source srcset="build/img/blog2.jpg" type="img/jpeg">
                    <img src="build/img/blog2.jpg" alt="Texto Entrada Blog" loading="lazy">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada.php">
                    <h4>Guía para la decoración de tu hogar</h4>
                    <p class="informacion-meta">Escrito el: <span>20/10/2023</span> Por: <span>Admin</span></p>
                    <p>Maximiza el espacio en tu hogar con esta guía, aprende a combinar muebles y colores y darle
                        vida a tu espacio.</p>
                </a>
            </div>
        </article>
    </section>
    <section class="testimoniales">
        <h2>Testimoniales</h2>
        <div class="testimonial">
            <blockquote>
                El personal se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron
                cumple con todas mis expectativas.
            </blockquote>
            <p>- Fabio Ibarra</p>
        </div>
    </section>
</div>