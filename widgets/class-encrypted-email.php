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

        $this->add_control(
            'separator_settings',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'View', 'elementor' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        // style tab
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Link', ENCRYPTED_EMAIL_FOR_ELEMENTOR_TD),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .encrypted-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .encrypted-link',
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

        $this->add_render_attribute(
            'link',
            [
                'class' => 'encrypted-link',
                'title' => settings['title'],
                'data-target' => base64_encode('mailto:' . $settings['address']),
                'href' => '#',
                'onclick' => 'location.href=atob(this.dataset.target);return false;',
            ]
        );

        $this->add_inline_editing_attributes( 'title' );

        $link_html = '<a ' . $this->get_render_attribute_string('link') . '>' . $settings['title'] . '</a>';

        echo $link_html;

        ?>
        <?php
    }
}
