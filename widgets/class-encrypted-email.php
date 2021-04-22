<?php
/**
 * ResponsiveImage class.
 *
 * @category   Class
 * @package    EncryptedEmailForElementor
 * @subpackage WordPress
 * @author     Samuel Goldenbaum
 * @copyright  2021 Samuel Goldenbaum
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link       https://github.com/samuelgoldenbaum/encrypted-email-for-elementor/
 * @since      1.0.0
 * php version 7.3.9
 */

namespace EncryptedEmailForElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Responsive\Responsive;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Plugin;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

require_once(__DIR__ . '/../constants.php');

/**
 * ResponsiveImage widget class.
 *
 * @since 1.0.0
 */
class EncryptedEmail extends Widget_Base
{
    /**
     * Class constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct($data = array(), $args = null) {
        parent::__construct($data, $args);

        // not really needed, lets save the http request
        // wp_register_style('encrypted-email-for-elementor', plugins_url('/assets/css/encrypted-email-for-elementor.css', ENCRYPTED_EMAIL_FOR_ELEMENTOR_FILE), array(), '1.0.0');

        wp_register_script('encrypted-email-for-elementor', plugins_url('/assets/js/encrypted-email-for-elementor.js', ENCRYPTED_EMAIL_FOR_ELEMENTOR_FILE), array(), '1.0.0');
    }

    /**
     * Retrieve the widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_name() {
        return 'encrypted-email';
    }

    /**
     * Retrieve the widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_title() {
        return __('Encrypted Email', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD);
    }

    /**
     * Retrieve the widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-link';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @return array Widget categories.
     * @since 1.0.0
     *
     * @access public
     *
     */
    public function get_categories() {
        return array('basic');
    }

    /**
     * Enqueue styles.
     */
    public function get_style_depends() {
        return array('encrypted-email-for-elementor');
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_shared',
            array(
                'label' => __('Settings', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
            )
        );

        $this->add_control(
            'address',
            [
                'label' => __('Address', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'description' => __('The unencrypted email address', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
//                'description' => __('The title to display on hover', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
            ]
        );

        $this->end_controls_section();

        // style tab
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $link_html = '<a data-target="' . $settings['address'] . '" ';
        if (isset($settings['title']) && trim($settings['title']) !== '') {
            $link_html .= ' title="' . $settings['title'] . '"';
        }
        $link_html .= '>' . $settings['title'] . '</a>';

        echo $link_html;

        ?>
        <?php
    }
}
