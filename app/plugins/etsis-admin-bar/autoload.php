<?php
function __autoload($class) {
	require_once(PLUGINS_DIR . 'etsis-admin-bar/lib/' . strtolower($class) . '.php');
}


function bootstrapItems($items) {
	
	// Starting from items at root level
	if( !is_array($items) ) {
		$items = $items->roots();
	}
	
	foreach( $items as $item ) {
	?>
		<li<?=($item->hasChildren()) ? ' class="dropdown"' : '';?>>
		<a href="<?php echo $item->link->get_url() ?>" <?=($item->hasChildren()) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';?>>
		 <?php echo $item->link->get_text() ?><?=($item->hasChildren()) ? ' <b class="caret"></b> ' : '';?></a>
		<?php if($item->hasChildren()): ?>
		<ul class="sub-dropdown dropdown-menu">
		<?php bootstrapItems( $item->children() ) ?>
		</ul> 
		<?php endif ?>
		</li>
	<?php
	}
}

?>