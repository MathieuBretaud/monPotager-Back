<?php

namespace monPotager;
use monPotager\Meta_semi;
use monPotager\Meta_planting;
use monPotager\Meta_harvest;
use monPotager\User_semi;

class Plugin
{
    /**
     * Constructeur de la classe Plugin
     * rajoute les hooks pour créer les taxo et CPT
     */
    public function __construct()
    {
        $mySemi = new Meta_semi();
        $myPlanting = new Meta_planting;
        $myHarvest = new Meta_harvest;
        $userSemi = new User_semi;
        $userPlanting = new User_planting;

        add_action('init', [$this, 'createPlanteCPT']);

        add_action('init', [$this, 'createPlanteTypeTaxonomy']);

        add_action('init', [$this, 'regions_Taxonomy']);

        add_action('init', [$this, 'season_Taxonomy']);

        add_action('add_meta_boxes', [$mySemi, 'metaboxes_StartSemi']);
        add_action('save_post', [$mySemi, 'save_metaboxes']);

        add_action('rest_api_init', [$this, 'api_meta']);

        add_action('add_meta_boxes', [$myPlanting, 'metaboxes_StartPlanting']);
        add_action('save_post', [$myPlanting, 'saveMetaboxesPlanting']);
        

        add_action('add_meta_boxes', [$myHarvest, 'metaboxes_StartHarvest']);
        add_action('save_post', [$myHarvest, 'saveMetaboxesHarvest']);

        add_action('add_meta_boxes', [$userSemi, 'user_Metaboxes_Semi']);
        add_action('save_post', [$userSemi, 'saveUserMetaboxesPeriodeSemi']);

        add_action('add_meta_boxes', [$userPlanting, 'user_Metaboxes_Planting']);
        add_action('save_post', [$userPlanting, 'saveUserMetaboxesDaysPlantation']);

        

        



        
    }

    /**
     * Rajoute un nouveau post type à wp
     * Cette fonction doit être appelée par un hook, si possible lors de l'action 'init'
     */
    public function createPlanteCPT()
    {
        register_post_type('plante', [

            'labels' => [
                'name'          => 'Plantes',
                'singular_name' => 'Plante',
                'add_new'       => 'Ajouter une plante',
                'add_new_item'  => 'Ajouter une plante',
                'not_found'     => 'Aucun plante trouvée',
                'edit_item'     => 'Modifier la plante',
            ],

            'public' => true,
            'menu_icon' => 'dashicons-carrot',
            add_theme_support('post-thumbnails'),

            //  Je veux que mes plantes apparaissent dans l'API fournis par WP
            'show_in_rest' => true,

            'supports' => [
                'title',
                'thumbnail',
                'editor',
            ],
        ]);
    }

    /**
     * Crée la taxonomie 'Ingrédient', liée au cpt Recipe
     */
    public function createPlanteTypeTaxonomy()
    {
        register_taxonomy(
            'plante_type',
            ['plante'],
            [
                'label' => 'Type de plante',
                'show_in_rest'  => true,
                'hierarchical'  => false,
                'public'        => true,
            ],
        );
    }

    public function regions_Taxonomy()
    {
        register_taxonomy(
            'regions',
            ['plante'],
            [
                'label' => 'Régions',
                'show_in_rest'  => true,
                'hierarchical'  => false,
                'public'        => true,
            ],
        );
    }

    public function season_Taxonomy()
    {
        register_taxonomy(
            'season',
            ['plante'],
            [
                'label' => 'Saisons',
                'show_in_rest'  => true,
                'hierarchical'  => false,
                'public'        => true,
            ],
        );
    }


    

    public function api_meta()
    {

        register_rest_field(
            'plante',
            'periode_plante',
            array(
                'get_callback' => [$this,'get_post_meta_for_api'],
                'schema' => null,
            )
        );
    }

    public function get_post_meta_for_api($object)
    {
        
        $post_id = $object['id'];
        //var_dump(get_post_meta($post_id));die;
        
        return get_post_meta($post_id);
    }


    

    // public function metaboxes_Plantation()
    // {

    //     add_meta_box('id_plantation', 'Plantation', [$this, 'start_plantation'], 'plante', 'side');
    // }

    



    
    
}
