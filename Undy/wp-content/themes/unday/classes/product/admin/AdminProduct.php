<?php
/**
 * AdminProduct
 *
 * The AdminProduct Class.
 *
 * @class    AdminProduct
 * @parent AdminBaseClass
 * @category Class
 * @author   Codingkart
 */  
class AdminProduct extends AdminBaseClass 
{	
  /**
   * Product Category for the Product Category class
   * Sets up all the appropriate hooks and actions
   * 
   */ 
	public function __construct(){

		add_action('admin_menu', array($this, 'createNewPageForProductStockManagementReport' ));

  
  }



    public function createNewPageForProductStockManagementReport(){
 
  	    add_submenu_page( 'woocommerce', 'product Stock Manage', 'Subscrition Stock Manage', 'manage_options', 'subscrition-product-stock-manage', 'my_custom_submenu_page_callback' ); 
    }

    public function my_custom_submenu_page_callback(){
    	 echo '<h3>Woocommerce Subscrition Product stock reserved list </h3>';

    }



}

new AdminProduct();