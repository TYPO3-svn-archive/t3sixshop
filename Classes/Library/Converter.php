<?php
namespace Arm\T3sixshop\Library;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Anisur Rahaman Mullick <anisur@armtechnologies.com>, ARM Technologies
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package t3sixshop
* @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
class Converter {
	
	/**
	 *
	 * @param \float $amt
	 * @return \string
	 */
	public static function getAmountInWords($amt) {
		$inword = "RUPEES ";
		$thPlace = 0;
		$hunPlace = 0;
		$tenPlace = 0;
		$unPlace = 0;
		$dec1 = 0;
		$dec2 = 0;
	
		if ($amt > 999) {
			$thPlace = intval($amt / 1000);
			$amt -= ($thPlace * 1000);
		}
	
		if ($amt > 99) {
			$hunPlace = (int) ($amt / 100);
			$amt -= ($hunPlace * 100);
		}
	
		$tenPlace = (int) ($amt / 10);
		$amt -= ($tenPlace * 10);
		$unPlace = (int)$amt;
	
		$amt -= $unPlace;
	
		if ($amt > 0) {
			$amt *= 100;
			$dec1 = (int) ($amt / 10);
			$amt -= ($dec1 * 10);
			$dec2 = (int)$amt;
		}
	
		if ($thPlace > 0) {
			$inword .= self::getNumWord($thPlace) . " THOUSAND ";
		}
	
		if($hunPlace > 0) {
			$inword .= self::getNumWord($hunPlace) . " HUNDRED ";
		}
	
		if ($tenPlace > 1) {
	
			if ($unPlace > 0) {
				$inword .= self::getNumTenWord($tenPlace) . " " . self::getNumWord($unPlace);
			}
			else {
				$inword .= self::getNumTenWord($tenPlace);
			}
		}
		elseif ($tenPlace == 1) {
			if ($unPlace == 0) {
				$inword .= self::getNumTenWord($tenPlace);
			}
			else  {
				$inword .= self::getNumTenTeenWord($unPlace);
			}
		}
		else {
			if ($unPlace > 0 || $dec1 > 0 || $dec2 > 0) {
				$inword .= self::getNumWord($unPlace);
			}
		}
	
		if ($dec1 > 0 || $dec2 > 0) {
			$inword .= " AND";
			if ($dec1 > 1) {
				if ($dec2 > 0) {
					$inword .= " " . self::getNumTenWord($dec1) . " " . self::getNumWord($dec2) . " PAISE ONLY";
				}
				else {
					$inword .= " " . self::getNumTenWord($dec1) . " PAISE ONLY";
				}
			}
			elseif ($dec1 == 1) {
				if ($dec2 == 0) {
					$inword .= " " . self::getNumTenWord($dec1) . " PAISE ONLY";
				}
				else {
					$inword .= " " . self::getNumTenTeenWord($dec2) . " PAISE ONLY";
				}
			}
			else {
				$inword .= " " . self::getNumWord($dec2) . " PAISE ONLY";
			}
		}
		else {
			$inword .= " ONLY";
		}
		return $inword;
	}
	
	/**
	 *
	 * @param int $n
	 * @return string
	 */
	protected static function getNumWord($n) {
		$wd = "";
		switch(intval($n)) {
			case 0:
				$wd = "ZERO";
				break;
			case 1:
				$wd = "ONE";
				break;
			case 2:
				$wd = "TWO";
				break;
			case 3:
				$wd = "THREE";
				break;
			case 4:
				$wd = "FOUR";
				break;
			case 5:
				$wd = "FIVE";
				break;
			case 6:
				$wd = "SIX";
				break;
			case 7:
				$wd = "SEVEN";
				break;
			case 8:
				$wd = "EIGHT";
				break;
			case 9:
				$wd = "NINE";
				break;
		}
		return $wd;
	}
	
	/**
	 *
	 * @param int $n
	 * @return string
	 */
	protected static function getNumTenWord($n) {
		$wd = "";
		switch (intval($n)) {
			case 1:
				$wd = "TEN";
				break;
			case 2:
				$wd = "TWENTY";
				break;
			case 3:
				$wd = "THIRTY";
				break;
			case 4:
				$wd = "FORTY";
				break;
			case 5:
				$wd = "FIFTY";
				break;
			case 6:
				$wd = "SIXTY";
				break;
			case 7:
				$wd = "SEVENTY";
				break;
			case 8:
				$wd = "EIGHTY";
				break;
			case 9:
				$wd = "NINETY";
				break;
		}
		return $wd;
	}
	
	/**
	 *
	 * @param int $n
	 * @return string
	 */
	protected static function getNumTenTeenWord($n) {
		$wd = "";
		switch (intval($n)) {
			case 1:
				$wd = "ELEVEN";
				break;
			case 2:
				$wd = "TWELVE";
				break;
			case 3:
				$wd = "THIRTEEN";
				break;
			case 4:
				$wd = "FOURTEEN";
				break;
			case 5:
				$wd = "FIFTEEN";
				break;
			case 6:
				$wd = "SIXTEEN";
				break;
			case 7:
				$wd = "SEVENTEEN";
				break;
			case 8:
				$wd = "EIGHTEEN";
				break;
			case 9:
				$wd = "NINETEEN";
				break;
		}
		return $wd;
	}
}