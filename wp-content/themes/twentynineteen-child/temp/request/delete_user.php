<?php

require_once( '../../../../wp-load.php' );
include_once( '../obj/UserAction.php' );

echo json_encode( $User_Action->delete_user( $_GET[ 'user_info_id' ] ) );
