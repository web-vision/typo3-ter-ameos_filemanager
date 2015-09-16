<?php

namespace Ameos\AmeosFilemanager\ViewHelpers;

class FilesizeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * Renders icon of extension $type
     *
     * @param string $size 
     * @return string
     */
    public function render($size) {
            $stringLength = strlen($size);
            $separatorNumber = 3;
            $separatorChar = ' ';
            $temp = $stringLength%$separatorNumber;
            $packOfThree = floor($stringLength / $separatorNumber);
            if($temp != 0) {
                $newString = substr($size, 0,$temp ).".".substr($size, $temp);
            }
            else {
                $newString = substr($size, 0,$separatorNumber ).".".substr($size, $separatorNumber);
                $packOfThree--;
            }
            return round($newString,2) . ' ' . $this->getUnit($packOfThree);
    }

    public function getUnit($packOfThree) {
        switch ($packOfThree) {
            case 0:
                return 'o';
                break;
            case 1:
                return 'Ko';
                break;
            case 2:
                return 'Mo';
                break;
            case 3:
                return 'Go';
                break;
            case 4:
                return 'To';
                break;
            case 5:
                return 'Po';
                break;
            default:
                break;
        }
    }
}