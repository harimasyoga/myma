<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;
 
$db['default'] = array( 
	'dsn'	=> '',
	'hostname' => 'localhost:3307',

	// LOCAL
	'username' => 'root',
	'password' => '',
	'database' => 'my_sipp',
	// 'hostname' => '109.106.252.101',

	// // LOCAL
	// 'username' => 'n1576051_ppiwng',
	// 'password' => 'primapaper2022',
	// 'database' => 'n1576051_db_penjualan',


	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	// 'db_debug' => false,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

// SIMROLL
$db['database_simroll'] = array( 
	'dsn'	=> '',
	// LOCAL
	'hostname' => 'localhost:3307',
	'username' => 'root',
	'password' => '',
	'database' => 'n1576051_db_ppi_fix',
	// SERVER
	// 'hostname' => '109.106.252.101',
	// 'username' => 'n1576051_ppiwng',
	// 'password' => 'primapaper2022',
	// 'database' => 'n1576051_db_ppi_fix',

	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


// // db 'ARTHA KARUNIA BERKAH'
// $db['db_hub_akb'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_akb',

// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'BERKAH SINAR MAKMUR'
// $db['db_hub_bsm'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_bsm',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'CAHAYA KARUNIA JAYA'
// $db['db_hub_ckj'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_ckj',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'GLOBAL MULIA BAKTI'
// $db['db_hub_gmb'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_gmb',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'JAYA SETIA KEMASAN'
// $db['db_hub_jsk'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_jsk',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'KEMASAN SENTOSA MULIA'
// $db['db_hub_ksm'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_ksm',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'MITRA MAJU MAKMUR'
// $db['db_hub_mmm'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_mmm',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'PUSAKA INDAH LESTARI'
// $db['db_hub_pil'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_pil',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'RUKUN SUMBER BERKAH'
// $db['db_hub_rsb'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_rsb',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );

// // db 'SUMBER SINAR BERKAT'
// $db['db_hub_ssb'] = array( 
// 	'dsn'	=> '',
// 	'hostname' => '109.106.252.101',

// 	// LOCAL
// 	'username' => 'n1576051_ppiwng',
// 	'password' => 'primapaper2022',
// 	'database' => 'n1576051_ppi_hub_ssb',
	
// 	'dbdriver' => 'mysqli',
// 	'dbprefix' => '',
// 	'pconnect' => FALSE,
// 	'db_debug' => (ENVIRONMENT !== 'production'),
// 	'cache_on' => FALSE,
// 	'cachedir' => '',
// 	'char_set' => 'utf8',
// 	'dbcollat' => 'utf8_general_ci',
// 	'swap_pre' => '',
// 	'encrypt' => FALSE,
// 	'compress' => FALSE,
// 	'stricton' => FALSE,
// 	'failover' => array(),
// 	'save_queries' => TRUE
// );