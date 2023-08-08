<?php

namespace BXG\App\Controllers ;

defined( 'ABSPATH' ) || exit ;

class AdminBxgTab 
{
    public static function woocommerceAdminTab ( $tabs )  
    {
        $tabs[ 'bxg_admin_tab' ] = array(
            'label' => __( 'Buy X Get X ' , 'text_domain' ) ,                                   // Tab Title
            'target' => 'bxg_tab_view' ,                                                        // Target ID
            'priority' => 50                                                                    // Priority
        ) ;
        return $tabs ;
    }

    public static function adminViewTabFunction ()
    {
        if ( file_exists( BXG_PLUGIN_PATH . '/App/Views/AdminBxgTabView.php' ) )
        {
            include ( BXG_PLUGIN_PATH . '/App/Views/AdminBxgTabView.php' ) ;
        }
        else
        {
            die ( 'View File Not Found' ) ;
        }
    }

    public static function bxgResponse () 
    {
        global $post ;
        if( isset ( $_POST [ 'buy_x_get_x' ] ) )
        {
            update_post_meta( $post->ID , 'bxgx' , '1' ) ;
        }
        else
        {
            delete_post_meta( $post->ID , 'bxgx' ) ;
        }
    }
}