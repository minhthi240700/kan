<?php

/**
 * Flatsome_Registration class.
 *
 * @package Flatsome
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Base Flatsome registration.
 */
class Flatsome_Base_Registration
{

	/**
	 * The UX Themes API instance.
	 *
	 * @var UxThemes_API
	 */
	protected $api;

	/**
	 * The option name.
	 *
	 * @var string
	 */
	protected $option_name;

	/**
	 * Setup instance.
	 *
	 * @param string $api         The UX Themes API instance.
	 * @param string $option_name The option name.
	 */
	public function __construct($api, $option_name)
	{
		$this->api         = $api;
		$this->option_name = $option_name;
		add_filter('pre_set_site_transient_update_themes', [$this, 'check_for_update']);
		add_action('after_setup_theme', [$this, 'fl_active']);
	}
	public function check_for_update($transient)
	{
		if (empty($transient->checked)) {
			return $transient;
		}

		$theme_slug = 'flatsome';
		$remote_url = 'https://wupdate.net/updates/?action=get_metadata&slug=' . $theme_slug;
		$response = wp_remote_get($remote_url);
		if (is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200) {
			return $transient;
		}

		$remote_version = json_decode(wp_remote_retrieve_body($response));
		if (!$remote_version) {
			return $transient;
		}

		$theme = wp_get_theme($theme_slug);
		if (version_compare($theme->get('Version'), $remote_version->version, '<')) {
			$transient->response[$theme_slug] = array(
				'theme'       => $theme_slug,
				'new_version' => $remote_version->version,
				'url'         => $remote_version->details_url,
				'package'     => $remote_version->download_url,
			);
		}

		return $transient;
	}

	public function fl_active()
	{
		if (false === get_option('flatsome_wup_purchase_code')) {
			add_option('flatsome_wup_purchase_code', 'GWrxBEss-VqSg-cJbs-dVvg-QzLEDfLzzExZ');
		}

		if (false === get_option('flatsome_wup_supported_until')) {
			add_option('flatsome_wup_supported_until', '14.07.2099');
		}

		if (false === get_option('flatsome_wup_buyer')) {
			add_option('flatsome_wup_buyer', 'Licensed');
		}

		if (false === get_option('flatsome_wup_sold_at')) {
			add_option('flatsome_wup_sold_at', time());
		}

		if (get_option('flatsome_wup_errors') !== false) {
			delete_option('flatsome_wup_errors');
		}

		if (get_option('flatsome_wupdates') !== false) {
			delete_option('flatsome_wupdates');
		}
	}

	/**
	 * Register theme.
	 *
	 * @param string $code The purchase code.
	 * @return array|WP_error
	 */
	public function register($code)
	{
		return new WP_Error(500, __('Not allowed.', 'flatsome'));
	}

	/**
	 * Unregister theme.
	 *
	 * @return array|WP_error
	 */
	public function unregister()
	{
		return new WP_Error(500, __('Not allowed.', 'flatsome'));
	}

	/**
	 * Check latest version.
	 *
	 * @return array|WP_error
	 */
	public function get_latest_version()
	{
		return new WP_Error(500, __('Not allowed.', 'flatsome'));
	}

	/**
	 * Get a download URL.
	 *
	 * @param string $version Version number to download.
	 * @return array|WP_error
	 */
	public function get_download_url($version)
	{
		return new WP_Error(500, __('Not allowed.', 'flatsome'));
	}

	/**
	 * Checks whether Flatsome is registered or not.
	 *
	 * @return boolean
	 */
	public function is_registered()
	{
		return false;
	}

	/**
	 * Checks whether the registration has been verified by Envato.
	 *
	 * @return boolean
	 */
	public function is_verified()
	{
		return false;
	}

	/**
	 * Checks whether registration is public or local.
	 *
	 * @return boolean
	 */
	public function is_public()
	{
		return true;
	}

	/**
	 * Returns the registered purchase code.
	 *
	 * @return string
	 */
	public function get_code()
	{
		return '';
	}

	/**
	 * Return the options array.
	 */
	public function get_options()
	{
		return get_option($this->option_name, array());
	}

	/**
	 * Updates the options array.
	 *
	 * @param array $data New data.
	 */
	public function set_options($data)
	{
		update_option($this->option_name, $data);
	}

	/**
	 * Delete the options array.
	 */
	public function delete_options()
	{
		delete_option($this->option_name);
	}

	/**
	 * Return a value from the option settings array.
	 *
	 * @param string $name Option name.
	 * @param mixed  $default The default value if nothing is set.
	 * @return mixed
	 */
	public function get_option($name, $default = null)
	{
		$options = $this->get_options();
		return isset($options[$name]) ? $options[$name] : $default;
	}

	/**
	 * Set option value.
	 *
	 * @param string $name Option name.
	 * @param mixed  $option Option data.
	 */
	public function set_option($name, $option)
	{
		$options          = $this->get_options();
		$options[$name] = wp_unslash($option);

		$this->set_options($options);
	}

	/**
	 * Deletes an option.
	 *
	 * @param string $name Option name.
	 */
	public function delete_option($name)
	{
		$options = $this->get_options();

		if (isset($options[$name])) {
			unset($options[$name]);
		}

		$this->set_options($options);
	}

	/**
	 * Set registration errors.
	 *
	 * @param string[] $errors The error messages.
	 * @return void
	 */
	public function set_errors(array $errors)
	{
		$errors = array_filter($errors);
		$this->set_option('errors', $errors);
		$this->set_option('show_notice', !empty($errors));
	}

	/**
	 * Get registration errors.
	 *
	 * @return string[]
	 */
	public function get_errors()
	{
		return array_filter($this->get_option('errors', array()));
	}

	/**
	 * Clears errors to hide admin notices etc.
	 */
	public function dismiss_notice()
	{
		$this->delete_option('show_notice');
	}
}
