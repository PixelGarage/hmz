<?php
  // prepare view elements
  drupal_add_library('system', 'ui.tabs');
  $slugs = array();
  $course = node_load($view->args[0]);
  // Lerncoaching = 91, Sprachen = 92
  $segment_id = $course->field_segment[LANGUAGE_NONE][0]['tid'];
  $nid = '6820'; // webform Anmeldung - Sprachen und Lerncoaching
  $form_anmeldung = drupal_render(node_view(node_load($nid)));
?>
<ul>
	<?php foreach ($view->result as $id => $data): ?>
		<?php
			$node = node_load($data->nid);
			$title = empty($node->field_tab_title) ? $node->title : $node->field_tab_title[LANGUAGE_NONE][0]['safe_value'];
 			$slug = str_replace('.', '_', transliteration_clean_filename(trim($title)));
			$slugs[$id] = $slug;
		?>
		<li><a href="#<?php print $slug; ?>"><?php print $title; ?></a></li>
	<?php endforeach; ?>

  <?php if (in_array($segment_id, array('91', '92'))): ?>
	  <li><a href="#startdaten">Anmeldung</a></li>
  <?php else: ?>
    <li><a href="#startdaten">Startdaten</a></li>
  <?php endif; ?>
</ul>
<?php foreach ($rows as $id => $row): ?>
  <div <?php if ($classes_array[$id]) { print 'class="' . $classes_array[$id] .'"';  } ?> id="<?php print $slugs[$id] ?>">
    <?php print $row; ?>
  </div>
<?php endforeach; ?>
<?php if (in_array($segment_id, array('91', '92'))): ?>
  <div class="views-row views-row-startdaten" id="startdaten">
    <?php print $form_anmeldung; ?>
  </div>
<?php else: ?>
  <div class="views-row views-row-startdaten" id="startdaten">
    <?php print views_embed_view('course_times'); ?>
  </div>
<?php endif; ?>
