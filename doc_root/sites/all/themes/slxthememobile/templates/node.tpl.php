<?php
//dsm($node);
?>
<h2 class="docu">
<?php if (isset($node -> field_pagbasica_seccion['und']))
        print $node -> field_pagbasica_seccion['und'][0]['value'];
?>
</h2>
<?php if (isset($node -> field_pagbasica_introduccion['und'])) { ?>
<div class="wysiwyg">
    <?php print $node -> field_pagbasica_introduccion['und'][0]['value']; ?>
</div>        
<?php } ?>

<?php if($node->type == "pagina_basica") { ?>
<h3 class="docu"><?php print $title; ?></h3>
<?php } ?>
<article>
        <?php print render($content); ?>
</article>