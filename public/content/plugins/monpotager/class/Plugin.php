<?php
namespace monPotager;

class Plugin {

    /**
     * Constructeur de la classe Plugin
     * rajoute les hooks pour créer les taxo et CPT
     */
    public function __construct()
    {
        add_action('init', [$this, 'createPlanteCPT']);

        add_action('init', [$this, 'createPlante_TypeTaxonomy']);

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
    public function createPlante_TypeTaxonomy()
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
}