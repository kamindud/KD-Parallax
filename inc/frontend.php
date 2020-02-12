<?php

class FrontEnd
{

    public function create_shortcode($post_id)
    {

        $html = '<div class="wrapper kd-paralax-wrapper">';
        $images = explode(',', get_post_meta($post_id, 'single_images', false)[0]);
        $main_titles = explode(',', get_post_meta($post_id, 'main_titles', false)[0]);
        $sub_titles = explode(',', get_post_meta($post_id, 'sub_titles', false)[0]);
        $main_colors = explode(',', get_post_meta($post_id, 'main_title_colors', false)[0]);
        $sub_colors = explode(',', get_post_meta($post_id, 'sub_title_colors', false)[0]);
        $moving_speed = explode(',', get_post_meta($post_id, 'moving_speed', false)[0]);
        $max_width = get_post_meta($post_id, 'max_image_width', false)[0];
        $max_height = get_post_meta($post_id, 'max_image_height', false)[0];
        $main_title_size = get_post_meta($post_id, 'main_font_size', false)[0];
        $sub_title_size = get_post_meta($post_id, 'sub_font_size', false)[0];

        foreach ($images as $key => $img) {
            $width = false;
            $height = false;

            if (!empty($max_width)) {
                $width = rand($max_width - 100, $max_width);
            }
            if (!empty($max_height)) {
                $height = rand($max_height - 100, $max_height);
            }
            $html .= '<div class="single-image"><a href="" class="single-image-inner" data-strength="' . $moving_speed[$key] . '">';
            $html .= '<img style="width:' . $width . 'px; max-height : ' . $height . 'px;" class="single-image-img" src="' . $img . '" alt="" srcset="">';
            $html .= '<h2 style="color:' . $main_colors[$key] . '; font-size: ' . $main_title_size . '" class="single-image-text">' . $main_titles[$key] . '</h2>';
            $html .= '<h3 style="color:' . $sub_colors[$key] . '; font-size: ' . $sub_title_size . '" class="single-img-sub">' . $sub_titles[$key] . '</h3></a></div>';
        }

        $html .= '</diV>';
        return $html;
    }
}
