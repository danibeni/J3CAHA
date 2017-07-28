<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_contact
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$this->params->set('show_category_heading_title_text', 0);

$this->subtemplatename = 'items';
echo JLayoutHelper::render('joomla.content.category_default', $this);
