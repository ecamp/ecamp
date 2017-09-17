<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
//  
//  Copyright (c) 2004-2005 Laurent Bedubourg
//  
//  This library is free software; you can redistribute it and/or
//  modify it under the terms of the GNU Lesser General Public
//  License as published by the Free Software Foundation; either
//  version 2.1 of the License, or (at your option) any later version.
//  
//  This library is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//  Lesser General Public License for more details.
//  
//  You should have received a copy of the GNU Lesser General Public
//  License along with this library; if not, write to the Free Software
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//  
//  Authors: Laurent Bedubourg <lbedubourg@motion-twin.com>
//  

require_once PHPTAL_DIR.'PHPTAL/Php/Attribute.php';

/**
 * @package phptal.php.attribute.phptal
 * @author Laurent Bedubourg <lbedubourg@motion-twin.com>
 */
class PHPTAL_Php_Attribute_PHPTAL_TALES extends PHPTAL_Php_Attribute
{
    public function start()
    {
        $mode = trim($this->expression);
        $mode = strtolower($mode);
        
        if ($mode == '' || $mode == 'default') 
            $mode = 'tales';
        
        if ($mode != 'php' && $mode != 'tales') {
            $err = "Unsupported TALES mode '%s'";
            $err = sprintf($err, $mode);
            throw new PHPTAL_Exception(
                $err, 
                $this->tag->getSourceFile(), 
                $this->tag->getSourceLine()
            ); 
        }
        
        $this->_oldMode = $this->tag->generator->setTalesMode( $mode );
    }

    public function end()
    {
        $this->tag->generator->setTalesMode( $this->_oldMode );
    }

    private $_oldMode;
}

?>
