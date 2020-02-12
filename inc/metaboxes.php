<?php

class KDMetaboxes
{

    public function create_content_metabox()
    {
        wp_nonce_field('kd_parallax_nonce', 'kd_parallax_nonce');
?>
        <script>
            let emptyImage = '<?php echo plugins_url('../assets/img/demo-img.png', __FILE__); ?>';
        </script>

        <div class="controller kd-main-div-wrapper">
            <?php

            $single_images_data = explode(',', get_post_meta(get_the_ID(), 'single_images', false)[0]);
            $main_titles_data = explode(',', get_post_meta(get_the_ID(), 'main_titles', false)[0]);
            $sub_titles_data = explode(',', get_post_meta(get_the_ID(), 'sub_titles', false)[0]);
            $main_title_colors_data = explode(',', get_post_meta(get_the_ID(), 'main_title_colors', false)[0]);
            $sub_title_colors_data = explode(',', get_post_meta(get_the_ID(), 'sub_title_colors', false)[0]);
            $moving_speed_data = explode(',', get_post_meta(get_the_ID(), 'moving_speed', false)[0]);
            $index = 0; ?>

            <input type="hidden" value="<?php echo get_post_meta(get_the_ID(), 'single_images', false)[0]; ?>" name="single-images" id="single-images">
            <input type="hidden" value="<?php echo get_post_meta(get_the_ID(), 'main_titles', false)[0]; ?>" name="main-titles" id="main-titles">
            <input type="hidden" value="<?php echo get_post_meta(get_the_ID(), 'sub_titles', false)[0]; ?>" name="sub-titles" id="sub-titles">
            <input type="hidden" value="<?php echo get_post_meta(get_the_ID(), 'main_title_colors', false)[0]; ?>" name="main-title-colors" id="main-title-colors">
            <input type="hidden" value="<?php echo get_post_meta(get_the_ID(), 'sub_title_colors', false)[0]; ?>" name="sub-title-colors" id="sub-title-colors">
            <input type="hidden" value="<?php echo get_post_meta(get_the_ID(), 'moving_speed', false)[0]; ?>" name="moving-speed" id="moving-speed">

            <?php
            foreach ($single_images_data as $single_el) {
                if (!empty($single_el)) { ?>


                    <div class="single-gal-element">
                        <div class="preview-img" id="single-<?php echo $index + 1; ?>">
                            <a class="close-single" data-id="<?php echo $index + 1; ?>" onclick="close_single_element(event)">X </a>
                            <a href="#" onclick="open_media(<?php echo $index + 1; ?>)" id="open-media"><img src="<?php echo $single_el; ?>" id="preview-thumb-<?php echo $index + 1; ?>" alt="" srcset=""></a>
                            <input value="<?php echo $main_titles_data[$index]; ?>" class="kd-single-input" type="text" id="single-main-title-<?php echo $index + 1; ?>" placeholder="Main Title">
                            <input value="<?php echo $sub_titles_data[$index]; ?>" class="kd-single-input" type="text" id="single-sub-title-<?php echo $index + 1; ?>" placeholder="Sub Title">
                            <input value="<?php echo $main_title_colors_data[$index]; ?>" class="kd-single-input" type="text" id="single-Main-color-<?php echo $index + 1; ?>" placeholder="Main Title Color">
                            <input value="<?php echo $sub_title_colors_data[$index]; ?>" class="kd-single-input" type="text" id="single-sub-color-<?php echo $index + 1; ?>" placeholder="Sub Title Color">
                            <input value="<?php echo $moving_speed_data[$index]; ?>" class="kd-single-input" type="text" id="single-moving-speed-<?php echo $index + 1; ?>" placeholder="Moving Speed">
                            <input type="button" class="kd-single-btn submit-single" onclick="submitSingle(<?php echo $index + 1; ?>)" value="Save">
                        </div>
                    </div>

            <?php
                    $index++;
                }
            };

            ?>

            <div class="single-gal-element">
                <div class="preview-img">
                    <a href="#" onclick="appendImg(event)"><img src="<?php echo plugins_url('../assets/img/add-img.jpg', __FILE__); ?>" alt="" srcset=""></a>
                </div>
            </div>
        </div>
    <?php
    }

    // create settings 
    public function create_settings_metabox()
    {
    ?>
        <div class="shortcode-sec">
            <h3 style="text-align: right">Use This Shortcode anywhere on your site. "<?php echo '[kd-parallax id="' . get_the_ID() . '"]'; ?>"</h3>
        </div>
        <div style="padding: 10px 0;">
            <label for="">Maximum Image Width : </label> <br>
            <input style="min-width:50%" type="number" name="max-image-width" placeholder="Maximum Image Width" value="<?php echo get_post_meta( get_the_ID(  ), 'max_image_width', false )[0]; ?>">
        </div>
        <div style="padding: 10px 0;">
            <label for="">Maximum Image Height : </label> <br>
            <input style="min-width:50%" type="number" name="max-image-height" placeholder="Maximum Image Height" value="<?php echo get_post_meta( get_the_ID(  ), 'max_image_height', false )[0]; ?>">
        </div>
        <div style="padding: 10px 0;">
            <label for="">Main Title Font Size : </label>
            <br>
            <input style="min-width:50%" type="number" name="main-font-size" placeholder="Main Title Font Size" value="<?php echo get_post_meta( get_the_ID(  ), 'main_font_size', false )[0]; ?>">
        </div>
        <div style="padding: 10px 0;">
            <label for="">Sub Title Font Size : </label>
            <br>
            <input style="min-width:50%" type="number" name="sub-font-size" placeholder="Sub Titile Font Size" value="<?php echo get_post_meta( get_the_ID(  ), 'sub_font_size', false )[0]; ?>">
        </div>

<?php  }

    // save metaboxes
    public function kd_save_post_meta($post_id, $post)
    {

        $meta_fields = [];


        // Check if our nonce is set.
        if (!isset($_POST['kd_parallax_nonce'])) {
            return;
        }

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($_POST['kd_parallax_nonce'], 'kd_parallax_nonce')) {
            return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check the user's permissions.
        if (isset($_POST['post_type']) && 'kd-parallax' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {

            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }


        // Sanitize user input.
        $meta_fields[] = ['single_images', sanitize_text_field($_POST['single-images'])];
        $meta_fields[] = ['main_titles',  sanitize_text_field($_POST['main-titles'])];
        $meta_fields[] = ['sub_titles', sanitize_text_field($_POST['sub-titles'])];
        $meta_fields[] = ['main_title_colors', sanitize_text_field($_POST['main-title-colors'])];
        $meta_fields[] = ['sub_title_colors', sanitize_text_field($_POST['sub-title-colors'])];
        $meta_fields[] = ['moving_speed', sanitize_text_field($_POST['moving-speed'])];
        $meta_fields[] = ['max_image_width' , sanitize_text_field( $_POST['max-image-width'])];
        $meta_fields[] = ['max_image_height' , sanitize_text_field( $_POST['max-image-height'])];
        $meta_fields[] = ['main_font_size' , sanitize_text_field( $_POST['main-font-size'])];
        $meta_fields[] = ['sub_font_size' , sanitize_text_field( $_POST['sub-font-size'])];
        $keys = [];
        // loop and save
        foreach ($meta_fields as $meta_field) {
            $keys[] = $meta_field[1];
            // update
            if (get_post_meta($post_id, $meta_field[0], false)) {
                update_post_meta($post_id, $meta_field[0], $meta_field[1]);
            } else {
                // add 
                add_post_meta($post_id, $meta_field[0], $meta_field[1]);
            }
            // delete
            if (!$meta_field) {
                // Delete the meta key if there's no value
                delete_post_meta($post_id, $meta_field[0]);
            }
        }
    }

    public function kd_create_metaboxes()
    {
        add_meta_box('kd-parallax-content', 'Add Images and other info', array($this, 'create_content_metabox'), 'kd-parallax', 'advanced', 'high');
        add_meta_box('kd-parallax-setting', "General Settings", array($this, 'create_settings_metabox'), 'kd-parallax', 'advanced', 'high');
    }
}
