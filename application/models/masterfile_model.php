<?php
class masterfile_model extends CI_Model {
    function random_string()
  {
    $character_set_array = array( );
    $character_set_array[ ] = array( 'count' => 1, 'characters' => 'abcdefghijklmnopqrstuvwxyz' );
    $character_set_array[ ] = array( 'count' => 10, 'characters' => '0123456789' ); //you can change count
    $temp_array = array( );
    foreach ( $character_set_array as $character_set )
    {
      for ( $i = 0; $i < $character_set[ 'count' ]; $i++ )
      {
        $temp_array[ ] = $character_set[ 'characters' ][ rand( 0, strlen( $character_set[ 'characters' ] ) - 1 ) ];
      }
    }
    shuffle( $temp_array );
    return implode( '', $temp_array );
  }
}
?>