<?php

namespace monPotager;

class Meta_planting
{

    public function metaboxes_StartPlanting()
    {

        add_meta_box('id_planting', 'Plantation', [$this, 'StartPlanting'], 'plante', 'side');
    }

    public function StartPlanting($post)
    {
        $val = get_post_meta($post->ID, 'debut_plantation', true);
        $value = get_post_meta($post->ID, 'fin_plantation', true);


        echo '<label for="start_planting">Début plantation : </label>';
        echo '<input id="start_planting" type="text" name="start_planting" value="' . $val . '" />';
        echo '<br>';
        echo '<label for="end_planting">Fin plantation : </label>';
        echo '<input id="end_planting" type="text" name="end_planting" value="' . $value . '" />';
    }


    public function saveMetaboxesPlanting($post_ID)
    {
        if (isset($_POST['start_planting']) && $_POST['start_planting'] !== '') {
            update_post_meta($post_ID, 'debut_plantation', esc_html($_POST['start_planting']));
        } else {

            delete_post_meta($post_ID, 'debut_plantation');
        }

        if (isset($_POST['end_planting']) && $_POST['end_planting'] !== '') {
            update_post_meta($post_ID, 'fin_plantation', esc_html($_POST['end_planting']));
        } else {

            delete_post_meta($post_ID, 'fin_plantation');
        }
    }

    




}
