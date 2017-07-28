<?php
// no direct access
defined ('_JEXEC') or die;
class plgContentAddContactField extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 * Note this is only available in Joomla 3.1 and higher.
	 * If you want to support 3.0 series you must override the constructor
	 *
	 * @var boolean
	 * @since <your version>
	 */
	protected $autoloadLanguage = true;
 
	/**
	 * Prepare form and add my field.
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   <your version>
	 */
	function onContentPrepareForm($form, $data)
	{
		$app    = JFactory::getApplication();
		$option = $app->input->get('option');
 
		switch($option)
		{
			case 'com_contact' :
				if ($app->isAdmin())
				{
					JForm::addFormPath(__DIR__ . '/forms');
					$form->loadFile('contact', false);
				}
 
				return true;
		}
 
		return true;
	}
}
?>
