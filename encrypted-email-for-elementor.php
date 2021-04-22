<?php
/**
 * Encrypted Email For Elementor
 *
 * @package EncryptedEmailForElementor
 *
 * Plugin Name: Encrypted Email For Elementor
 * Description: Add encrypted email links to avoid spam crawling.
 * Plugin URI:  https://github.com/samuelgoldenbaum/encrypted-email-for-elementor/
 * Version:     1.0.0
 * Author:      Samuel Goldenbaum
 * Author URI:  https://github.com/samuelgoldenbaum/
 * Text Domain: encrypted-email-for-elementor
 */

define( 'ENCRYPTED_EMAIL_FOR_ELEMENTOR_FILE', __FILE__ );

/**
 * Include the class.
 */
require plugin_dir_path( ENCRYPTED_EMAIL_FOR_ELEMENTOR_FILE ) . 'class-encrypted-email-for-elementor.php';
