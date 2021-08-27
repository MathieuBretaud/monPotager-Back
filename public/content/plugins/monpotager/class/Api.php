<?php

namespace monPotager;

use WP_REST_Request;
use WP_User;

class Api
{
    /**
     * @var string
     */
    protected $baseURI;

    public function __construct()
    {
        // registration of our custom api
        add_action('rest_api_init', [$this, 'initialize']);

        add_action('rest_api_init', [$this, 'api_meta']);
    }

<<<<<<< HEAD
    public function api_meta()
    {

        register_rest_field(
            'user',
            'region',
            array(
                'get_callback' => [$this, 'get_user_meta_for_api'],
                'schema' => null,
            )
        );
    }

    public function get_user_meta_for_api($object)
    {
        $user_id = $object['id'];
        //var_dump(get_post_meta($post_id));die;

        return get_user_meta($user_id, 'region', true);
    }
=======
>>>>>>> develop

    public function initialize()
    {
        // retrieve a folder name from a file path 
        $this->baseURI = dirname($_SERVER['SCRIPT_NAME']);

        // Create new API route
        register_rest_route(
            'monpotager/v1', // name of an API
            '/inscription', // the endpoint that will be put after the name of the api
            [
                'methods' => 'post', // the method used
                'callback' => [$this, 'inscription']
            ]
        );

        register_rest_route(
            'monpotager/v1',
<<<<<<< HEAD
            '/plante-save',
=======
            '/plantation-save', 
>>>>>>> develop
            [
                'methods' => 'post',
                'callback' => [$this, 'plantationSave']
            ]
        );

        register_rest_route(
            'monpotager/v1',
            '/plantation-delete', 
            [
                'methods' => 'post',
                'callback' => [$this, 'plantationDelete']
            ]
        );

        register_rest_route(
            'monpotager/v1',
            '/plantation-update', 
            [
                'methods' => 'post',
                'callback' => [$this, 'plantationUpdate']
            ]
        );

        register_rest_route(
            'monpotager/v1',
            '/plantation-select', 
            [
                'methods' => 'post',
                'callback' => [$this, 'plantationSelect']
            ]
        );
    }

<<<<<<< HEAD
    public function planteSave(WP_REST_Request $request)
    {
        $id_user = $request->get_param('id_user');
        $id_plante = $request->get_param('id_plante');
        //$status = $request->get_param('status');
=======
    public function plantationSelect(WP_REST_Request $request)
    {
        $id_user = $request->get_param('id_user');

        // $user = wp_get_current_user();
        // $id_user = $user->id;

        //if (in_array('gardener', (array) $user->roles)) {

        $gardenerPlantation = new GardenerPlantation();
        $result = $gardenerPlantation->getPlantationsByUserId($id_user);
    
        return [
            'status'     => 'sucess',
            'id_user'    => $id_user,
            'plantations' => $result
        ];
    }

    public function plantationUpdate(WP_REST_Request $request)
    {
        $id_plantation = $request->get_param('id_plantation');
        $id_user = $request->get_param('id_user');
        $status = $request->get_param('status');
        $id_plante = $request->get_param('id_plante');

        // $user = wp_get_current_user();
        // $id_user = $user->id;
>>>>>>> develop

        //if (in_array('gardener', (array) $user->roles)) {
        
        $gardenerPlantation = new GardenerPlantation();
        $gardenerPlantation->update($id_user, $id_plantation, $id_plante, $status);

        return [
            'status requête'=> 'sucess',
            'id_user'       => $id_user,
            'id_plantation' => $id_plantation, 
            'id_plante'     => $id_plante,
            'status'        => $status
        ];
    }

<<<<<<< HEAD
        //if (in_array('gardener', (array) $user->roles)) {
        $gardenerPlantation = new GardenerPlantation();
        $gardenerPlantation->insert($id_user, $id_plante );

        return [
            'status' => 'sucess',
        ];
        // } else  {
        //     return [
        //          'status' => 'failed',
        //     ];
        // }   
=======
    public function plantationDelete(WP_REST_Request $request)
    {
        $id_plantation = $request->get_param('id_plantation');
        $id_user = $request->get_param('id_user');

        // $user = wp_get_current_user();
        // $id_user = $user->id;

        //if (in_array('gardener', (array) $user->roles)) {
        
        $gardenerPlantation = new GardenerPlantation();
        $gardenerPlantation->delete($id_user, $id_plantation);

        return [
            'status'        => 'sucess',
            'id_user'       => $id_user,
            'id_plantation' => $id_plantation
        ];
    }

    public function plantationSave(WP_REST_Request $request) {
        $id_plante = $request->get_param('id_plante');
        //$status = $request->get_param('status');
        $id_user = $request->get_param('id_user');

        // $user = wp_get_current_user();
        // $id_user = $user->id;

        //if (in_array('gardener', (array) $user->roles)) {
            $gardenerPlantation = new GardenerPlantation();
            $gardenerPlantation->insert($id_user, $id_plante);

            return [
                'status'    => 'sucess',
                'id_user'   => $id_user,
                'id_plante' => $id_plante, 
            ];
        //} else  {
            //  return [
            //      'status' => 'failed',
            // ];
        //}
>>>>>>> develop
    }

    public function inscription(WP_REST_Request $request)
    {
        $email = $request->get_param('email');
        $password = $request->get_param('password');
        $userName = $request->get_param('username');
        $region = $request->get_param('region');

        // Create new user
        $userCreateResult = wp_create_user(
            $userName,
            $password,
            $email,
        );

        // Verification that the user has been created
        if (is_int($userCreateResult)) {

            $user = new WP_User($userCreateResult);

            add_user_meta($user->id, 'region', $region, true);

            // Remove role
            $user->remove_role('subscriber');
            // Add role
            $user->add_role('gardener');

            // values that will be returned by the api 
            return [
                'success'   => true,
                'userId'    => $userCreateResult,
                'username'  => $userName,
                'email'     => $email,
                'region'    => $region,
                'role'      => 'gardener'
            ];
        } else {  // if the user was not created, the error occurred
            return [
                'success' => false,
                'error' => $userCreateResult
            ];
        }
    }
<<<<<<< HEAD
}
=======

    public function api_meta()
    {

        register_rest_field(
            'user',
            'region',
            array(
                'get_callback' => [$this,'get_user_meta_for_api'],
                'schema' => null,
            )
        );
    }

    public function get_user_meta_for_api($object)
    {
        $user_id = $object['id'];
        //var_dump(get_post_meta($post_id));die;
        
        return get_user_meta( $user_id, 'region', true);
    }   
}
>>>>>>> develop
