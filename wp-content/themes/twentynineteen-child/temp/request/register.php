<?php

/**
 * Registration Response
 * Method: POST
 * 
 */

require_once '../../../../wp-load.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username       = $_POST['username'];
    $password       = $_POST['password'];
    $user_role      = $_POST['role'];
    $upline_id      = $_POST['upline_id'];
    $position       = $_POST['position'];

    $status = [];

    global $wpdb;

    $is_referral_id_exist = $wpdb->get_var( 'SELECT COUNT(`user_id`) FROM `j_users` WHERE `user_id`=' . $referral_id . '' );

    /**
     * Check if referral id exist
     * if not then throw error message
     * 
     */
    if ($is_referral_id_exist) {

        $is_upline_id_exist = $wpdb->get_var( 'SELECT COUNT(`user_id`) FROM `j_users` WHERE `user_id`=' . $upline_id . '' );

        /**
         * Check if upline id exist
         * if not then throw error message
         * 
         */
        if ($is_upline_id_exist) {

            $is_username_exist = $wpdb->get_var( 'SELECT COUNT(`user_info_id`) FROM `j_users_info` WHERE `user_username`=' . $username . '' );

            /**
             * Check if username exist
             * if exist then throw error message
             * 
             */
            if (!$is_username_exist) {
    
                $wpdb->query( 'INSERT INTO `j_users` (`user_id`) VALUES (NULL)' );
    
                $users_last_id = $wpdb->get_var( 'SELECT `user_id` FROM `j_users` ORDER BY `user_id` DESC LIMIT 1' );
    
                $user_insert_data = $wpdb->insert(
                    'j_users_info',
                    array(
                        'ID' => $users_last_id,
                        'user_username' => $username,
                        'user_password' => $password,
                        'user_role' => $user_role,
                        'user_upline_id' => $upline_id,
                        'user_position' => $position                    
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );
    
                /**
                 * If insertion success
                 * 
                 */
                if ($user_insert_data) {
    
                    $status = [
                        'status' => 'success',
                        'message' => 'User successfully registered.'
                    ];
    
                } else {
    
                    $status = [
                        'status' => 'failed',
                        'message' => 'Registration Failed.'
                    ];
    
                }
    
            } else {
    
                $status = [
                    'status' => 'failed',
                    'message' => 'Username already exist.'
                ];
    
            }

        } else {

            $status = [
                'status' => 'failed',
                'message' => "Upline ID doesn't exist."
            ];

        }

    } else {

        $status = [
            'status' => 'failed',
            'message' => "Referral ID doesn't exist."
        ];

    }

    /**
     * Return Status
     * 
     */
    echo json_encode($status);

} else { // If direct access

    header('Location: /juncture/page-error/?error=direct_access');
    die();

}