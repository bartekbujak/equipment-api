<?php
/**
 * Created by PhpStorm.
 * User: bbujak
 * Date: 24.08.2018
 * Time: 10:14
 */

namespace AppBundle\Utils;

use AppBundle\Entity\Machine;

class DateCompareHelper
{
    /**
     * @var array
     */
    public $terms;

    /**
     * @var string
     */
    public $basicData;

    /**
     * @var array
     */
    public $preparedTerms = [];

    /**
     * DateCompareHelper constructor.
     * @param array $terms
     * @param $basicData
     */
    public function __construct(array $terms, $basicData)
    {
        $this->terms = $terms;
        $this->basicData = $basicData;
    }

    public function compareTerms()
    {
        if (!$this->terms) {
            return;
        }

        foreach($this->terms as $term) {
            $this->_assignRow($term);
        }
    }

    /**
     * assign row to preparedTerms array
     * @param Machine $term
     */
    protected function _assignRow(Machine $term)
    {
        $date = new \DateTime($this->basicData);
        $date->modify($term->getDay());
        $termDate = $date->format('Y-m-d');
        $dateKey = array_search($termDate,  array_column($this->preparedTerms, 'date'));

        if ($dateKey === false) {
            $newRow  = [
                'date' => $termDate,
                'hours' => [[$term->getStartHour(), $term->getEndHour()]]
            ];
            array_push($this->preparedTerms, $newRow);

            return;
        }

        $this->_assignRowByRange($dateKey, $term);

    }

    /**
     * @param $dateKey
     * @param $term
     */
    protected function _assignRowByRange($dateKey, Machine $term)
    {
        $lastRange = end($this->preparedTerms[$dateKey]['hours']);

        if ($term->getEndHour() > $lastRange[1] && $term->getStartHour() < $lastRange[1]) {
            $this->preparedTerms[$dateKey]['hours'][key($lastRange)] = [$lastRange[0], $term->getEndHour()];
            return;
        }

        if ($term->getEndHour() < $lastRange[1] && $term->getStartHour() < $lastRange[1]) {
            return;
        }

        array_push( $this->preparedTerms[$dateKey]['hours'], [$term->getStartHour(), $term->getEndHour()]);
    }
}