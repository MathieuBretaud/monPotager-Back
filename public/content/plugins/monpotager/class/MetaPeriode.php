<?php

namespace monPotager;

class MetaPeriode
{
    const calendrier = [
        'Janvier'   => '2021-01-01',
        'Février'   => '2021-02-01',
        'Mars'      => '2021-03-01',
        'Avril'     => '2021-04-01',
        'Mai'       => '2021-05-01',
        'Juin'      => '2021-06-01',
        'Juillet'   => '2021-07-01',
        'Aout'      => '2021-08-01',
        'Septembre' => '2021-09-01',
        'Octobre'   => '2021-10-01',
        'Novembre'  => '2021-11-01',
        'Décembre'  => '2021-12-01'
    ];

    const colors = [
        'Légume'     => '#067106',
        'Fruit'      => '#0E5671',
        'Arôme'      => '#719C0F'
    ];

    const regions = [
        'Auvergne'      => '_auvergne',
        'Bourgogne'     => '_bourgogne',
        'Bretagne' => '_bretagne',
        'Centre' => '_centre',
        'Corse' => '_corse',
        'Est' => '_est',
        'Hauts' => '_hauts',
        'Ile' => '_ile',
        'Normandie' => '_normandie',
        'Aquitaine' => '_aquitaine',
        'Occitanie' => '_occitanie',
        'Loire' => '_loire',
        'Azur' => '_azur',
    ];


    public function metaboxesloadSemi()
    {
        add_meta_box('regions', 'Periode de culture ', [$this, 'loadRegions'], 'plante', 'normal');
        //add_meta_box('auvergne', 'Periode de culture Auvergne-Rhône-Alpes', [$this, 'loadAuvergne'], 'plante', 'normal');
        // add_meta_box('bourgogne', 'Periode de culture Bourgogne-Franche-Comté', [$this, 'loadBourgogne'], 'plante', 'normal');
        // add_meta_box('bretagne', 'Periode de culture Bretagne', [$this, 'loadBretagne'], 'plante', 'normal');
        // add_meta_box('centre', 'Periode de culture Centre-Val de Loire', [$this, 'loadCentre'], 'plante', 'normal');
        // add_meta_box('corse', 'Periode de culture Corse', [$this, 'loadCorse'], 'plante', 'normal');
        // add_meta_box('est', 'Periode de culture Grand Est', [$this, 'loadEst'], 'plante', 'normal');
        // add_meta_box('hauts', 'Periode de culture Hauts', [$this, 'loadHauts'], 'plante', 'normal');
        // add_meta_box('ile', 'Periode de culture Île-de-France', [$this, 'loadIle'], 'plante', 'normal');
        // add_meta_box('aquitaine', 'Periode de culture Nouvelle-Aquitaine', [$this, 'loadAquitaine'], 'plante', 'normal');
        // add_meta_box('normandie', 'Periode de culture Normandie', [$this, 'loadNormandie'], 'plante', 'normal');
        // add_meta_box('occitanie', 'Periode de culture Occitanie', [$this, 'loadOccitanie'], 'plante', 'normal');
        // add_meta_box('loire', 'Periode de culture Pays de la Loire', [$this, 'loadLoire'], 'plante', 'normal');
        // add_meta_box('azur', 'Periode de culture Provence-Alpes-Côte d’Azure', [$this, 'loadAzur'], 'plante', 'normal');



        add_meta_box('colors_type', 'Couleurs de type', [$this, 'loadcolor'], 'plante', 'side');
    }

    public function loadRegions($post)
    {
        foreach (self::regions as $region => $value) {
            // *************** START SEMIS ****************** //
            $valueMonthBeginsSemis = get_post_meta($post->ID, 'start_semi' . $value, true);
            echo "<div style='border:solid 2px #c3c4c7; margin-bottom: 1rem;padding:0.5rem'>";
            echo "<h1>$region :</h1>";
            echo '<label for="dispo_meta">Indiquez la periode de semis - Début : </label>';
            echo '<select name="start_semi' . $value . '">';
            foreach (self::calendrier as $month => $TabValue) {
                echo '<option' . selected($TabValue, $valueMonthBeginsSemis, false) . ' value="' . $TabValue . '" >' . $month . '</option>';
            }
            echo '</select>';

            // *************** END SEMIS ****************** //
            $valueMonthEndsSemis = get_post_meta($post->ID, 'end_semi' . $value, true);
            echo '<label for="dispo_meta"> Fin : </label>';
            echo '<select name="end_semi' . $value . '">';
            foreach (self::calendrier as $month => $TabValue) {
                echo '<option ' . selected($TabValue, $valueMonthEndsSemis, false) . ' value="' . $TabValue . '">' . $month . '</option>';
            }
            echo '</select><br>';

            // *************** START PLANTATION ****************** //
            $valueMonthBeginsPlants = get_post_meta($post->ID, 'start_plant' . $value, true);
            echo '<label for="dispo_meta">Indiquez la periode de plantation - Début : </label>';
            echo '<select name="start_plant' . $value . '">';
            foreach (self::calendrier as $month => $TabValue) {
                echo '<option ' . selected($TabValue, $valueMonthBeginsPlants, false) . ' value="' . $TabValue . '">' . $month . '</option>';
            }
            echo '</select>';


            // *************** END PLANTATION *************** //
            $valueMonthEndsPlants = get_post_meta($post->ID, 'end_plant' . $value, true);

            echo '<label for="dispo_meta"> Fin : </label>';
            echo '<select name="end_plant' . $value . '">';
            foreach (self::calendrier as $month => $TabValue) {
                echo '<option ' . selected($TabValue, $valueMonthEndsPlants, false) . ' value="' . $TabValue . '">' . $month . '</option>';
            }
            echo '</select><br>';


             // *********** START HARVEST *************** //
            $valueMonthBeginsHarvest = get_post_meta($post->ID, 'start_harvest' . $value, true);

            echo '<label for="dispo_meta">Indiquez la periode de récolte - Début : </label>';
            echo '<select name="start_harvest'.$value.'">';
            foreach (self::calendrier as $month => $TabValue) {
                if ($TabValue === $valueMonthBeginsHarvest) {
                    echo '<option ' . selected($TabValue, $valueMonthBeginsHarvest, false) . ' value="' . $TabValue . '" selected>' . $month . '</option>';
                } else {
                    echo '<option ' . selected($TabValue, $valueMonthBeginsHarvest, false) . ' value="' . $TabValue . '">' . $month . '</option>';
                }
            }
            echo '</select>';


            // *********** END HARVEST *************** //
            $valueMonthEndsHarveset = get_post_meta($post->ID, 'end_harvest' . $value, true);

            echo '<label for="dispo_meta"> Fin : </label>';
            echo '<select name="end_harvest' .$value. '">';
            foreach (self::calendrier as $month => $TabValue) {
                echo '<option ' . selected($TabValue, $valueMonthEndsHarveset, false) . ' value="' . $TabValue . '">' . $month . '</option>';
            }
            echo '</select></div>';
            }
    }

    public function save_metaboxe($post_ID)
    {
        foreach (self::regions as $region => $value) {
            // *********** SEMIS ************ //
            if (isset($_POST['start_semi' . $value]) && $_POST['start_semi' . $value] !== '') {
                update_post_meta($post_ID, 'debut_semi' . $value, esc_html($_POST['start_semi' . $value]));
            } else {
                delete_post_meta($post_ID, 'debut_semi' . $value);
            }

            // *************** END SEMIS ****************** //
            if (isset($_POST['end_semi' . $value]) && $_POST['end_semi' . $value] !== '') {
                update_post_meta($post_ID, 'fin_semi' . $value, esc_html($_POST['end_semi' . $value]));
            } else {
                delete_post_meta($post_ID, 'fin_semi' . $value);
            }

            // *********** PLANTATION ************ //
            if (isset($_POST['start_plant' . $value]) && $_POST['start_plant' . $value] !== '') {
                update_post_meta($post_ID, 'debut_plant' . $value, esc_html($_POST['start_plant' . $value]));
            } else {
                delete_post_meta($post_ID, 'debut_plant' . $value);
            }

            if (isset($_POST['end_plant' . $value]) && $_POST['end_plant' . $value] !== '') {
                update_post_meta($post_ID, 'fin_plant' . $value, esc_html($_POST['end_plant' . $value]));
            } else {
                delete_post_meta($post_ID, 'fin_plant' . $value);
            }

            // *********** RECOLTE *************** //

            if (isset($_POST['start_harvest' .$value]) && $_POST['start_harvest' .$value] !== '') {
                update_post_meta($post_ID, 'debut_recolte'.$value, esc_html($_POST['start_harvest'.$value]));
            } else {
                delete_post_meta($post_ID, 'debut_recolte'.$value);
            }

            if (isset($_POST['end_harvest'.$value]) && $_POST['end_harvest' .$value] !== '') {
                update_post_meta($post_ID, 'fin_recolte'.$value, esc_html($_POST['end_harvest' .$value]));
            } else {
                delete_post_meta($post_ID, 'fin_recolte' .$value);
            }
        }
    }



    public function loadcolor($post)
    {
        // *************** START SEMIS ****************** //
        $valueMonthBeginsSemis = get_post_meta($post->ID, 'colorsType', true);

        echo '<label for="dispo_meta">Indiquez le type pour la couleur affiché sur le calendrier </label>';
        echo '<select name="nameColors">';
        foreach (self::colors as $month => $TabValue) {
            echo '<option' . selected($TabValue, $valueMonthBeginsSemis, false) . ' value="' . $TabValue . '" >' . $month . '</option>';
        }
        echo '</select>';
    }
}
