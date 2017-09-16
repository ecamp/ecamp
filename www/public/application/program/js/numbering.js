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

var decnumerals = "0123456789";
var romnumerals = "IVXLCDM";
var maxdec = 9999;
var maxrom = 21;

function getrom (position, digit) {
  if (position == 1) {
    if (digit == 0) return "";
    if (digit == 1) return "I";
    if (digit == 2) return "II";
    if (digit == 3) return "III";
    if (digit == 4) return "IV";
    if (digit == 5) return "V";
    if (digit == 6) return "VI";
    if (digit == 7) return "VII";
    if (digit == 8) return "VIII";
    if (digit == 9) return "IX";
  }
  if (position == 2) {
    if (digit == 0) return "";
    if (digit == 1) return "X";
    if (digit == 2) return "XX";
    if (digit == 3) return "XXX";
    if (digit == 4) return "XL";
    if (digit == 5) return "L";
    if (digit == 6) return "LX";
    if (digit == 7) return "LXX";
    if (digit == 8) return "LXXX";
    if (digit == 9) return "XC";
  }
  if (position == 3) {
    if (digit == 0) return "";
    if (digit == 1) return "C";
    if (digit == 2) return "CC";
    if (digit == 3) return "CCC";
    if (digit == 4) return "CD";
    if (digit == 5) return "D";
    if (digit == 6) return "DC";
    if (digit == 7) return "DCC";
    if (digit == 8) return "DCCC";
    if (digit == 9) return "CM";
  }
  if (position == 4) {
    var roman = "";
    for (var i = 1; i <= digit; i++) {
      roman = roman + "M";
    }
    return roman;
  }
}

function dectorom ( int ) 
{
  var decinput = int.toString().replace(/^ */,"");
  decinput = decinput.replace(/ *$/,"");
  decinput = decinput.replace(/^0*/,"");

  for (var i = 0; i < decinput.length; i++) {
    if (decnumerals.indexOf(decinput.charAt(i)) == -1) {
      return "";
    }
  }

  if (decinput > maxdec) {
    return "";
  }

  var i = decinput.length - 1;
  var romoutput = "";
  while (i >= 0 ) {
    romoutput = getrom((decinput.length - i),decinput.charAt(i)) + romoutput;
    i--;
  }
  return romoutput;
}


