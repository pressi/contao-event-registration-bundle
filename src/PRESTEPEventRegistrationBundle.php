<?php
/*******************************************************************
 * (c) 2019 Stephan Preßl, www.prestep.at <development@prestep.at>
 * All rights reserved
 * Modification, distribution or any other action on or with
 * this file is permitted unless explicitly granted by PRESTEP
 * www.prestep.at <development@prestep.at>
 *******************************************************************/

namespace PRESTEP\EventRegistrationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use PRESTEP\EventRegistrationBundle\DependencyInjection\PRESTEPEventRegistrationExtension;


/**
 * Configures the Contao PRESTEP Event Registration Bundle.
 *
 * @author Stephan Preßl <development@prestep.at>
 */
class PRESTEPEventRegistrationBundle extends Bundle
{

    /**
     * Register extension
     *
     * @return PRESTEPEventRegistrationExtension
     */
    public function getContainerExtension()
    {
        return new PRESTEPEventRegistrationExtension();
    }



    public static function getBundleFolder()
    {
        $arrBundle      = explode("\\", self::class);
        $strFolder      = strtolower( $arrBundle[0] ) . '/contao';

        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $arrBundle[1],$matches);

        foreach( $matches[0] as $bundlePart )
        {
            $strFolder .= '-' . strtolower( $bundlePart );
        }

        return $strFolder;
    }



    public static function getBundleTableListener( $strTable )
    {
        $tableClass             = '';
        $arrTableClass          = explode("_", preg_replace('/^tl_/', '', $strTable));

        foreach($arrTableClass as $classNamePart)
        {
            $tableClass .= ucfirst($classNamePart);
        }

        $arrBundle              = explode("\\", self::class);
        $strBundleTableListener = $arrBundle[0] . '\\' . $arrBundle[1] . '\\Table\\' . $tableClass . 'Table';

        if( class_exists( $strBundleTableListener ) )
        {
            return $strBundleTableListener;
        }

        return '';
    }
}
