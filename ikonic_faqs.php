<?php
/**
 * Plugin Name: IKONIC FAQs
 * Description: Add FAQs custom post type
 * Author: Muhammad Tauseef
 * Version: 1.0.0
 * Developed By: Muhammad Tauseef
 * Text Domain: ikonic_faqs
 * Domain Path: /languages
*/

if ( ! defined( 'WPINC' ) ) {
	wp_die();
}

class Ikonic_Faqs {
    public function __construct() {
        add_action('init', array($this, 'ik_add_custom_post_types'));
        add_action('init', array($this, 'include_ik_files'));
        add_shortcode('list_faqs', array($this, 'IKOFAQ_list_faqs'));

    }
    public function IKOFAQ_list_faqs() {
        ob_start();
        $IKOFAQ_faqs = get_posts(array("post_type"=> "ikonic_faqs"));
        ?>
        <div class="IKOFAQ_faqs">
            <?php
            foreach($IKOFAQ_faqs as $IKOFAQ_faq) {
                $post_id = $IKOFAQ_faq->ID;
                $IKOFAQ_question = get_post_meta($post_id, 'IKOFAQ_question', true);
                $IKOFAQ_answer = get_post_meta($post_id, 'IKOFAQ_answer', true);

                ?>
                <div class="IKOFAQ_faq">
                    <div class="IKOFAQ_question">
                        <b>
                            <?php echo "Q: $IKOFAQ_question"; ?>
                        </b>
                    </div>
                    <div class="IKOFAQ_answer">
                        <?php echo "A: $IKOFAQ_answer"; ?>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
    }

    public function include_ik_files() {
        if ( !is_admin() ) {
            // include plugin_dir_path( __FILE__ ) . '/public/CS_frontend.php';
            add_action('wp_enqueue_scripts', array($this, 'ikonic_faq_styles'));
        } else {
            include plugin_dir_path( __FILE__ ) . '/admin/IKOFAQ_admin.php';
        }
    }

    public function ikonic_faq_styles() {
        wp_enqueue_style('ikonic_front_style', plugins_url('ikonic_faqs_styles/ikonic_styles.css', __FILE__), array() , '1.0.0');
    }

    public function ik_add_custom_post_types() {
        $labels = array(
            'name'               => __( 'Ikonic Faqs', 'ikonic_faqs' ),
            'singular_name'      => __( 'Ikonic Faq', 'ikonic_faqs' ),
            'menu_name'          => __( 'Ikonic Faqs', 'ikonic_faqs' ),
            'name_admin_bar'     => __( 'Ikonic Faqs', 'ikonic_faqs' ),
            'add_new'            => __( 'Add New Ikonic Faq', 'ikonic_faqs' ),
            'add_new_item'       => __( 'Add New Ikonic Faq', 'ikonic_faqs' ),
            'new_item'           => __( 'New ', 'ikonic_faqs' ),
            'edit_item'          => __( 'Edit Ikonic Faq', 'ikonic_faqs' ),
            'view_item'          => __( 'View Ikonic Faq', 'ikonic_faqs' ),
            'all_items'          => __( 'Ikonic Faqs', 'ikonic_faqs' ),
            'search_items'       => __( 'Search Social Shared Posts', 'ikonic_faqs' ),
            'not_found'          => __( 'No Ikonic Faq found.', 'ikonic_faqs' ),
            'not_found_in_trash' => __( 'No Ikonic Faq found in Trash.', 'ikonic_faqs' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_admin_bar'  => true,
            'show_in_menu'        => true,
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'supports'           => array( 'title'),
        );

        register_post_type( 'ikonic_faqs', $args );
    }
}
new Ikonic_Faqs();