<?php

namespace BXG\App\Controllers ;

defined( 'ABSPATH' ) || exit ;

class CartPageBxg 
{
    
    public static function getCartProducts ()
    {
        global $woocommerce ; 
        // Cart Items List
        $cartItems = $woocommerce->cart->get_cart() ;      
        foreach ( $cartItems as $cartItemKey => $cartItem )
        {
            $cartProductId = $cartItem[ 'product_id' ] ;
            $cartProductCartKey = $cartItemKey ;
            $cartProductOfferDetails = get_post_meta( $cartProductId , 'bxgx' , true ) ;
            // Check for the offer
            if ( !array_key_exists( 'product_parent_id' , $cartItem ) && $cartProductOfferDetails == 1  )                      
            {
                $newFreeProduct = true ;
                $cartProductCartId = $cartItemKey ;
                foreach ( $cartItems as $cartItemKey => $newcartItem )
                {
                    if (isset($newcartItem [ 'product_parent_id' ]) && $newcartItem [ 'product_parent_id' ] == $cartProductCartId )                                          //Free Product exist in cart
                    {
                        $newFreeProduct = false ;
                    }
                }
                if ( $newFreeProduct == true )
                {
                    if( $cartItem[ 'variation_id' ] == 0 )                                                                     // Free for variation product
                    {   
                        $offeredProductId = $cartProductId ;
                        $duplicateProductData = $cartItem;
                        $mainProductQuantity = $cartItem [ 'quantity' ] ;
                        $duplicateProductData [ 'product_parent_id' ] = $cartProductCartKey ;
                        $woocommerce->cart->add_to_cart( 
                            $offeredProductId ,                                         // Product ID
                            $mainProductQuantity ,                                      // Quantity
                            0 ,                                                         // Variation ID
                            array() ,                                                   // Variation
                            $duplicateProductData                                       // Cart Item Data
                        ) ; 
                    }
                    else                                                                                                       // Free for Product
                    {
                        $offeredProductId = $cartProductId ;
                        $duplicateProductData = $cartItem;
                        $mainProductQuantity = $cartItem [ 'quantity' ] ;
                        $mainProductVariationId = $cartItem [ 'variation_id' ] ;
                        $mainProductVariation = $cartItem [ 'variation' ] ;
                        $duplicateProductData [ 'product_parent_id' ] = $cartProductCartKey ;
                        $woocommerce->cart->add_to_cart( 
                            $offeredProductId ,                                         // Product ID
                            $mainProductQuantity ,                                      // Quantity
                            $mainProductVariationId ,                                   // Variation ID
                            $mainProductVariation ,                                     // Variation
                            $duplicateProductData                                       // Cart Item Data
                        ) ; 
                    }
                }         
            }   
        } 
        $updatedCartItems = $woocommerce->cart->get_cart() ;
        foreach ( $updatedCartItems as $cartItemKey => $updatedcartItem )
        {
            if ( array_key_exists( 'product_parent_id' , $updatedcartItem ) )
            {
                $originalProductNotOccur = true ;
                $updatedcartItem[ 'data' ]->set_price( 0 ) ;
                $offerProductCartKey = $cartItemKey ;
                $parentProductId = $updatedcartItem [ 'product_parent_id' ] ;
                foreach ( $updatedCartItems as $cartItemKey => $cartItem  )
                {
                    if ( $parentProductId == $cartItemKey )
                    {
                        $originalProductNotOccur = false ;
                        if ( $cartItem[ 'quantity' ] > 0 )
                        {
                            $woocommerce->cart->set_quantity( $offerProductCartKey , $cartItem[ 'quantity' ]  ) ;           // Set Quantity for Free Product
                        }
                    }
                }
                if ( $originalProductNotOccur == true )
                {
                    $woocommerce->cart->remove_cart_item( $cartItemKey ) ;
                }
            }
        } 
    }

    public static function cartFreeLabel (  $product_name , $cart_item )                                                    // Free label
    {
        $product = $cart_item['data']; 
        if( $product->price == 0 ){

            $product_name .= '<br><span class="custom_field_class price">Free</span>';
        }
        return $product_name;
    }

    public static function cartRemoveQuantityOption (  $product_quantity , $cart_item_key , $cart_item )                    // Disabling Quantity Selector  
    {
        $product = $cart_item['data']; 
        if( $product->price == 0 ){
            $product_quantity = '<span>'.$cart_item['quantity'].'</span>' ;
        }
        return $product_quantity;
    }

    public static function cartRemoveOption (  $button_link , $cart_item_key  )                                             //Disabling Remove button
    {
        $product = WC()->cart->get_cart()[ $cart_item_key ] ; 
        if( $product['data']->price == 0 ){

            $button_link = '' ;
        }
        return $button_link;
    }
}

        