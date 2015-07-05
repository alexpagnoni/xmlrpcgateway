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
require( "auth.php" );

if ( !defined( "LOCALE_LIBRARY"   ) ) include( LIBRARY_PATH."locale.library"   );
if ( !defined( "OOPHTML_LIBRARY"  ) ) include( LIBRARY_PATH."oophtml.library"  );
if ( !defined( "ADMINGUI_LIBRARY" ) ) include( LIBRARY_PATH."admingui.library" );
if ( !defined( "MODULES_LIBRARY"  ) ) include( LIBRARY_PATH."modules.library"  );

$adloc = new Locale( "xmlrpcgateway", AMP_LOCALE );
$page = new HtmlPage( $adloc->GetStr( "title" ) );
$page->add( pagecaption( $adloc->GetStr( "title" ) ) );
$modcfg = new moduleconfig( $env["ampdb"], "xmlrpcgateway" );

switch ( $env["disp"]["pass"] )
{
case "setcfg":
    $modcfg->setkey( "DEST_HOST", $env["disp"]["desthost"] );
    $modcfg->setkey( "DEST_PORT", $env["disp"]["destport"] );
    $modcfg->setkey( "DEST_CGI", $env["disp"]["destcgi"] );
    break;
}

switch ( $env["disp"]["act"] )
{
case "def":
    $table[0][0] = new htmltext( $adloc->GetStr( "hostdesc" ) );
    $table[1][0] = new htmlformtext( "", "desthost", $modcfg->getkey( "DEST_HOST" ), "", 20 );
    $table[0][1] = new htmltext( $adloc->GetStr( "hostnote" ) );
    $table[0][1]->colspan = 2;
    $table[0][2] = new htmltext( $adloc->GetStr( "portdesc" ) );
    $table[1][2] = new htmlformtext( "", "destport", $modcfg->getkey( "DEST_PORT" ), "", 20 );
    $table[0][3] = new htmltext( $adloc->GetStr( "portnote" ) );
    $table[0][3]->colspan = 2;
    $table[0][4] = new htmltext( $adloc->GetStr( "cgidesc" ) );
    $table[1][4] = new htmlformtext( "", "destcgi", $modcfg->getkey( "DEST_CGI" ), "", 20 );
    $table[0][5] = new htmltext( $adloc->GetStr( "cginote" ) );
    $table[0][5]->colspan = 2;
    $table[0][6] = new htmlslist( array( new htmlraw( "<center>" ),
                                         new htmlformsubmit( "submit", $adloc->GetStr( "submit" ) ),
                                         new htmlformreset( "reset", $adloc->GetStr( "reset" ) ),
                                         new htmlraw( "</center>" )
                                       )
                                );
    $table[0][6]->setcolspan( 2 );
    $table[0][6]->align = "center";

    $form[0] = new htmlraw( "<center>" );
    $form[1] = new htmltable( $table, 5, 2 );
    $form[1]->setwidth( "" );
    $form[2] = new htmlraw( "</center>" );
    $form[3] = new htmlformhidden( "act",  "def" );
    $form[4] = new htmlformhidden( "pass", "setcfg" );

    $page->add( new htmlform( $PHP_SELF, $form, true, false ) );
    break;
}

echo $page->draw( 1 );
?>
