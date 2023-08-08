<?php

namespace BXG\App ;

use BXG\App\Controllers\AdminBxgTab;
use BXG\App\Controllers\CartPageBxg;

defined( 'ABSPATH' ) || exit ;

class Route 
{
    public static function bxgFunction ()
    {
        if (is_admin())
        {
            $adminTab = new AdminBxgTab();
            add_filter( 'woocommerce_product_data_tabs' , [ $adminTab , 'woocommerceAdminTab' ] ) ;
            add_action( 'woocommerce_product_data_panels' , [ $adminTab , 'adminViewTabFunction' ] ) ;
            add_action( 'woocommerce_admin_process_product_object' , [ $adminTab , 'bxgResponse' ] ) ;
        }
        else
        {
            $cartPage = new  CartPageBxg() ;
            add_action( 'woocommerce_before_cart_contents' , [ $cartPage , 'getCartProducts' ] ) ;
            add_filter( 'woocommerce_cart_item_name', [ $cartPage , 'cartFreeLabel' ] , 10 , 2 );
            add_filter( 'woocommerce_cart_item_quantity', [ $cartPage , 'cartRemoveQuantityOption' ] , 10 , 3 ) ;
            add_filter( 'woocommerce_cart_item_remove_link', [ $cartPage , 'cartRemoveOption' ] , 10 , 2 ) ;
        }
    }
}

