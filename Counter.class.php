<?php
/**
 * Counter extension for MediaWiki
 * Allows auto counting of objects in a page
 *
 * @file
 * @ingroup Extensions
 * @author Rinick
 * @date 2010/01/05
 * @version 0.2
 * @link http://www.mediawiki.org/wiki/Extension:Counter Documentation
 * @license http://www.mozilla.org/MPL/2.0/ Mozilla Public License 2.0
 */
 
if ( !defined( 'MEDIAWIKI' ) ) {
        die( 'This file is an extension to MediaWiki and thus not a valid entry point.' );
}

class Counter
{
	var $counterDict = array();

	public static function registerParser( &$parser ) {
        $parser->setFunctionHook( '+', [$this, 'wfParserFunctionCounter_Render'] );
        return true;
	}
	
	function wfParserFunctionCounter_Render( &$parser, $param1 = '', $param2 = '', $param3 = '' )
	{
		global $counterDict;

		$str = trim($param1);
		$keys = trim($param2);
		$num = intval($param3);
		if ($num == 0)
		{
			$idx = strpos($str, ' ');
			if ($idx)
			{
				$num = intval(substr($str, 0, $idx));
				if ($num != 0)
				{
					$name = substr($str, $idx + 1);
				}
				else if (substr($str, 0, 1) == '?')
				{
					$num = '?';
					$name = trim(substr($str,1));
				}
				else
				{
					$num = 1;
					$name = $str;
				}
			}
			else
			{
				$num = 1;
				$name = $str;
			}
		}
		if ($keys)
		{
			$keys = explode(',', $keys);
		}
		else
		{
			$keys = array($name);
		}
		if ($num == '?')
		{
			$num = 0;
			foreach ($keys as $key)
			{
				$num += $counterDict[trim($key)];
			}
			$str = $num . ' ' . $name;
		}
		else
		{
			foreach ($keys as $key)
			{
				$counterDict[trim($key)] += $num;
			}
		}
		return $str;
	}
}
