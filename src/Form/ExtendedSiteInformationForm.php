<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Form\SiteInformationForm;


class ExtendedSiteInformationForm extends SiteInformationForm {
 
   /**
   * {@inheritdoc}
   */
	  public function buildForm(array $form, FormStateInterface $form_state) {
		$site_config = $this->config('system.site');
		$form =  parent::buildForm($form, $form_state);
		$form['site_information']['siteapikey'] = [
			'#type' => 'textfield',
			'#title' => t('Site API Key'),
			'#default_value' => $site_config->get('siteapikey') ?: 'No API Key yet',
			'#description' => t("Custom field to set the API Key"),
		];
        $form['actions']['submit']['#value'] = t('Update Configuration');
		
		return $form;
	}
	
	  public function submitForm(array &$form, FormStateInterface $form_state) {
		$this->config('system.site')
		  ->set('siteapikey', $form_state->getValue('siteapikey'))
          ->save();
          drupal_set_message($form['site_information']['siteapikey']['#value'].' - Site API Key updated.');
		parent::submitForm($form, $form_state);
        
	  }
}