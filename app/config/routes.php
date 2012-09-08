<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
	
	Router::connect('/', array('controller' => 'members', 'action'=> 'index'));
//	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
 Router::connect('/admin', array('controller' => 'members', 'action' => 'login', 'prefix' => 'admin', 'admin' => true));
 Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
 Router::connect('/tutor/*', array('controller' => 'members', 'action' => 'tutor'));
 Router::connect('/non_profit/*', array('controller' => 'members', 'action' => 'non_profit'));
 Router::connect('/about_us/*', array('controller' => 'homes', 'action' => 'about_us'));
 Router::connect('/site_map/*', array('controller' => 'homes', 'action' => 'site_map'));
 Router::connect('/contact_us/*', array('controller' => 'homes', 'action' => 'contact_us'));
 Router::connect('/privacy_policy/*', array('controller' => 'homes', 'action' => 'privacy_policy'));
 Router::connect('/terms_of_service/*', array('controller' => 'homes', 'action' => 'terms_of_service'));
  Router::connect('/parents/*', array('controller' => 'homes', 'action' => 'parents'));
 
 
?>