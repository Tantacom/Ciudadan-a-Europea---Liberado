<?php

?>
<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $options['type'] will either be ul or ol.
 * @ingroup views_templates
 */
?>
<?php foreach ($rows as $id => $row): ?>
    <article class="news summary cl <?php print $classes_array[$id]; ?>"><?php print $row; ?></article>
<?php endforeach; ?>



