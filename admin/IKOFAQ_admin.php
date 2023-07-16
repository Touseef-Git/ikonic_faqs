<?php
class IKOFAQ_admin {
	public function __construct() {
		add_action( 'add_meta_boxes', array($this, 'IKOFAQ_add_custom_metaboxes'));
		add_action('save_post_ikonic_faqs', array($this, 'IKOFAQ_save_update_data'));
	}
	

	public function IKOFAQ_save_update_data($post_id) {
		$post = get_post($post_id);

		if($post->post_status !== 'publish') {
			return;
		}

		$IKOFAQ_question = $_POST['IKOFAQ_question'];
		$IKOFAQ_answer = $_POST['IKOFAQ_answer'];

		update_post_meta($post_id, 'IKOFAQ_question', $IKOFAQ_question);
		update_post_meta($post_id, 'IKOFAQ_answer', $IKOFAQ_answer);

	}

	public function IKOFAQ_add_custom_metaboxes() {
		add_meta_box(
			'IKOFAQ_box_id',                 // Unique ID
			'Add Extra Details',      // Box title
			'IKOFAQ_custom_box_html',  // Content callback, must be of type callable
			'ikonic_faqs'                            // Post type
		);

		function IKOFAQ_custom_box_html($post) {

			$post_id = $post->ID;
			$IKOFAQ_question = get_post_meta($post_id, 'IKOFAQ_question', true);
			$IKOFAQ_answer = get_post_meta($post_id, 'IKOFAQ_answer', true);

			 ?>
			 <div class="IKOFAQ_container">
			 	<div class="IKOFAQ_">
			 		<h3>
			 			Enter The Question:
			 		</h3>
			 		<textarea name="IKOFAQ_question" cols="100" rows="5"><?php echo $IKOFAQ_question ?></textarea>
			 	</div>
			 	<div class="IKOFAQ_answer">
			 		<h3>
			 			Enter The Answer:
			 		</h3>
			 		<textarea name="IKOFAQ_answer" cols="100" rows="5"><?php echo $IKOFAQ_answer ?></textarea>
			 	</div>

			 </div>
			 <?php
		}
	}
}
new IKOFAQ_admin();