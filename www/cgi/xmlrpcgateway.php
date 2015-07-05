<?php
/*
 *              The Ampoliros II Web Applications Platform
 *
 *                      http://www.ampoliros.com
 *
 *                           XMLRPC Gateway
 *
 *   Copyright (C) 2000-2001 Solarix
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 */

require( "cfgpath.php" );

if ( !defined( "DBLAYER_LIBRARY" ) ) include( LIBRARY_PATH."dblayer.library" );
if ( !defined( "MODULES_LIBRARY" ) ) include( LIBRARY_PATH."modules.library" );

// Ampoliros database
//
$args["dbname"] = AMP_DBNAME;
$args["dbhost"] = AMP_DBHOST;
$args["dbport"] = AMP_DBPORT;
$args["dbuser"] = AMP_DBUSER;
$args["dbpass"] = AMP_DBPASS;
$args["dbtype"] = AMP_DBTYPE;
$args["dblog"]  = AMP_DBLOG;

$env["ampdb"] = &NewDbLayer( $args );
$env["ampdb"]->Connect( $args );

$env["modcfg"] = new ModuleConfig( $env["ampdb"], "xmlrpcgateway" );

global $HTTP_RAW_POST_DATA;
global $PHP_AUTH_USER;
global $PHP_AUTH_PW;

$credentials = "";
$resp = "";

$username = $PHP_AUTH_USER;
$password = $PHP_AUTH_PW;

$dest_host = $env["modcfg"]->GetKey( "DEST_HOST" );
$dest_port = $env["modcfg"]->GetKey( "DEST_PORT" );
$dest_cgi  = $env["modcfg"]->GetKey( "DEST_CGI" );

if ( $username != "" )
{
    $credentials = "Authorization: Basic ".base64_encode( $username.":".$password )."\r\n";
}

// Prepare request
//
$op = "POST ".$dest_cgi." HTTP/1.0\r\n".
"User-Agent: XMLRPC Gateway 1.0.0\r\n".
"Host: 192.168.1.2\r\n".
$credentials.
"Content-Type: text/xml\r\nContent-Length: " .
strlen( $HTTP_RAW_POST_DATA )."\r\n\r\n".
$HTTP_RAW_POST_DATA;

// Open socket to destination
//
$xrsock = fsockopen( $dest_host, $dest_port );

// Send request
//
fputs( $xrsock, $op, strlen( $op ) );

// Read response
//
while( !feof( $xrsock ) )
{
    $resp .= fgets( $xrsock, 128 );
}

// Close socket
//
fclose( $xrsock );

// Output response
//
echo $resp;
?>