<?php
/*
 * Copyright (C) 2010 Urban Suppiger, Pirmin Mattmann
 *
 * This file is part of eCamp.
 *
 * eCamp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * eCamp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with eCamp.  If not, see <http://www.gnu.org/licenses/>.
 */

	function thumbnail( $PicPathIn, $PicPathOut, $PicFilenameIn, $PicFilenameOut, $neueHoehe, $Quality )
    {
          // Bilddaten ermitteln
          $size=getimagesize("$PicPathIn"."$PicFilenameIn");
          $breite=$size[0];
          $hoehe=$size[1];

          $neueBreite = intval($breite*$neueHoehe/$hoehe);

          if($size[2]==1)
          {
                       // GIF
                       $altesBild=ImageCreateFromGIF("$PicPathIn"."$PicFilenameIn");
                       $neuesBild=imageCreateTrueColor($neueBreite,$neueHoehe);
                       imageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
                       imageJPEG($neuesBild,"$PicPathOut"."$PicFilenameOut",$Quality);
          }

          if($size[2]==2)
          {
                       // JPG
                       $altesBild=ImageCreateFromJPEG("$PicPathIn"."$PicFilenameIn");
                       $neuesBild=imageCreateTrueColor($neueBreite,$neueHoehe);
                       imageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
                       ImageJPEG($neuesBild,"$PicPathOut"."$PicFilenameOut",$Quality);
          }

          if($size[2]==3)
          {
                       // PNG
                       $altesBild=ImageCreateFromPNG("$PicPathIn"."$PicFilenameIn");
                       $neuesBild=imageCreateTrueColor($neueBreite,$neueHoehe);
                       imageCopyResized($neuesBild,$altesBild,0,0,0,0,$neueBreite,$neueHoehe,$breite,$hoehe);
                       ImageJPEG($neuesBild,"$PicPathOut"."$PicFilenameOut",$Quality);
          }
    }

	$avatar = $_FILES['avatar'];
	if( !$avatar )	{	header("Location: index.php?app=user_profile");	die();	}
	
	thumbnail( "", "", $avatar['tmp_name'], $avatar['tmp_name'], 200, 90 );
	
	$imgData = addslashes( file_get_contents( $avatar['tmp_name'] ) );
	
	mysqli_query($GLOBALS["___mysqli_ston"],  "SET CHARACTER SET 'binary'" );
	
	$query = "	UPDATE user SET image = '$imgData' WHERE id = $_user->id";
	mysqli_query($GLOBALS["___mysqli_ston"], $query);
	
	header("Location: index.php?app=user_profile");
	die();
