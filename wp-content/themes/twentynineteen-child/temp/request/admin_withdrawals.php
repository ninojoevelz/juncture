<?php

require_once( '../../../../wp-load.php' );
include_once( '../obj/UserData.php' );

echo json_encode( $User_Data->get_users_withdrawal_status() );
