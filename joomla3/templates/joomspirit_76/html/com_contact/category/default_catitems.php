<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.core');

$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));

/*
 * DBH: 27/07/2017
 * Access to the database table __contact_detais to get all the contacts within a Contact 
 * Category identified by an ID. 
 */
$db = JFactory::getDbo();
$id = $this->category->id;//

$query = $db->getQuery(true);
$query->select('*');
$query->from('#__contact_details');
$query->where('catid="'.$id.'"');
$query->order('ordering');

$db->setQuery((string)$query);
$contacts = $db->loadObjectList();

?>
	<style>
		table.category {table-layout: fixed;}
		div.thumbnail img {
			width: 40px; 
			height: 40px;
			border: none;
			margin: 0 auto;
		}
		div.thumbnail img:hover {
		  -webkit-transform: matrix(2, 0, 0, 2, 15, 0);
		  -moz-transform: matrix(2, 0, 0, 2, 15, 0);;
		  -o-transform: matrix(2, 0, 0, 2, 15, 0);;
		  transform: matrix(2, 0, 0, 2, 15, 0);;
		  transition: all 0.3s;
		  -webkit-transition: all 0.3s;

		}
    	span.contact_name {font-size: 14px; font-weight: bold;}
	</style>
	
	<table class="category">
		<col width="30%">
		<?php if ($this->params->get('show_headings')) : ?>
		<thead><tr>
			<th class="item-title">
				<?php echo JText::_('COM_CONTACT_CONTACT_EMAIL_NAME_LABEL'); ?>
			</th>
			<?php if ($this->params->get('show_position_headings')) : ?>
			<th class="item-position">
				<?php echo JText::_('COM_CONTACT_POSITION'); ?>
			</th>
			<?php endif; ?>
			<?php if ($this->params->get('show_email_headings')) : ?>
			<th class="item-email">
				<?php echo JText::_('JGLOBAL_EMAIL'); ?>
			</th>
			<?php endif; ?>
			<?php if ($this->params->get('show_telephone_headings')) : ?>
			<th class="item-phone">
				<?php echo JText::_('COM_CONTACT_TELEPHONE'); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_mobile_headings')) : ?>
			<th class="item-phone">
				<?php echo JText::_('COM_CONTACT_MOBILE'); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_fax_headings')) : ?>
			<th class="item-phone">
				<?php echo JText::_('COM_CONTACT_FAX'); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_suburb_headings')) : ?>
			<th class="item-suburb">
				<?php echo JHtml::_('grid.sort', 'COM_CONTACT_SUBURB', 'a.suburb', $listDirn, $listOrder); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_state_headings')) : ?>
			<th class="item-state">
				<?php echo JHtml::_('grid.sort', 'COM_CONTACT_STATE', 'a.state', $listDirn, $listOrder); ?>
			</th>
			<?php endif; ?>

			<?php if ($this->params->get('show_country_headings')) : ?>
			<th class="item-state">
				<?php echo JHtml::_('grid.sort', 'COM_CONTACT_COUNTRY', 'a.country', $listDirn, $listOrder); ?>
			</th>
			<?php endif; ?>

			</tr>
		</thead>
		<?php endif; ?>

		<tbody>
    			<?php foreach ($contacts as $i => $item) : ?>
    				<tr class="<?php echo ($i % 2) ? "odd" : "even"; ?>" itemscope itemtype="https://schema.org/Person">
    					<td class="item-title">
    							<?php 
    							 /*
    							  * DBH: 27/07/2017
    							  * New div to include an thumbnail image of the contact
    							  */
    							?>
    						    <div class="thumbnail">
    								<?php if ($item->image && $this->params->get('show_image')) : ?>
    									<?php echo JHtml::_('image', $item->image, $item->name, array('align' => 'middle', 'itemprop' => 'image')); ?>
    								<?php endif; ?>
    								<span class="contact_name" itemprop="name"><?php echo $item->name; ?></span>
    							</div>					
					</td>

					<?php if ($this->params->get('show_position_headings')) : ?>
						<td class="item-position" itemprop="jobTitle">
							<?php echo $item->con_position; ?>
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_email_headings')) : ?>
						<td class="item-email" itemprop="email">
							<?php  echo JHtml::_('email.cloak', $item->email_to, 1); ?>
							<?php 
							     /*
							      * DBH: 27/07/2017
							      * Get params from the contact ($item) recovered from the database
							      * and convert the params string to a JSON object in order to get the
							      * field related to the additional email address (contact_email2)
							      */
							     $item_params_str = $item->params;
							     $item_params = json_decode($item_params_str);
							?>
							<?php if (!empty($item_params->{'contact_email2'})) : ?>
								 <br />
								<?php echo JHtml::_('email.cloak', $item_params->{'contact_email2'}, 1); ?>
							<?php endif; ?>							
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_telephone_headings')) : ?>
						<td class="item-phone" itemprop="telephone">
							<?php echo $item->telephone; ?>
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_mobile_headings')) : ?>
						<td class="item-phone" itemprop="telephone">
							<?php echo $item->mobile; ?>
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_fax_headings')) : ?>
						<td class="item-phone" itemprop="faxNumber">
							<?php echo $item->fax; ?>
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_suburb_headings')) : ?>
						<td class="item-suburb" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
							<span itemprop="addressLocality"><?php echo $item->suburb; ?></span>
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_state_headings')) : ?>
						<td class="item-state" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
							<span itemprop="addressRegion"><?php echo $item->state; ?></span>
						</td>
					<?php endif; ?>

					<?php if ($this->params->get('show_country_headings')) : ?>
						<td class="item-state" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
							<span itemprop="addressCountry"><?php echo $item->country; ?></span>
						</td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>

		</tbody>
	</table>
	

