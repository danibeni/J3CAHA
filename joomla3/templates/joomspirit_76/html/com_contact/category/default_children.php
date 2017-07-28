<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$class = ' class="first"';

if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) :
?>
<?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
	<?php
	if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) :
		if (!isset($this->children[$this->category->id][$id + 1]))
		{
			$class = ' class="last"';
		}

	?>

	<h1 class="item-title">
		<?php echo $this->escape($child->title); ?>
	</h1>
	<?php if ($this->params->get('show_subcat_desc') == 1) : ?>
		<?php if ($child->description) : ?>
			<div class="category-desc">
				<?php echo JHtml::_('content.prepare', $child->description, '', 'com_contact.category'); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($child->numitems > 0 ) :
		$this->children[$child->id] = $child->getChildren();
		$this->category = $child;
		$this->maxLevel--;
		echo $this->loadTemplate('catitems');
		$this->category = $child->getParent();
		$this->maxLevel++;
	endif; ?>
	
	<?php endif; ?>
<?php endforeach; ?>

<?php endif; ?>
