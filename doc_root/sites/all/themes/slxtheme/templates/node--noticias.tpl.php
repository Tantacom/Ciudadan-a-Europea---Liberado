<h2 class="news">Actualidad</h2>
<article class="news">
    <h3 class="titular"><?php print $title; ?></h3>
    <?php print render($content['field_noticias_fecha']); ?>
    <div class="wysiwyg">
        <?php print render($content['field_noticias_texto']); ?>
        <?php print render($content['field_noticias_descargas']); ?>
        <?php print render($content['field_noticias_enlaces']); ?>
    </div>
</article>