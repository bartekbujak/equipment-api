<?php

namespace AppBundle\Repository;

class MachineRepository extends \Doctrine\ORM\EntityRepository
{

    public function findTermInSameDay($machineName, $day) {
        $query = $this->createQueryBuilder('m');
        $query->where("m.day =:day");
        $query->andWhere("m.name =:machineName");
        $query->setParameter('day', $day);
        $query->setParameter('machineName', $machineName);

        return $query->getQuery()->execute();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function findWithOrderByDays($data)
    {
        $query = $this->createQueryBuilder('m');
        $query->addSelect("(
            CASE WHEN m.day = 'Sun' THEN 1
            WHEN m.day = 'Mon' THEN 2
            WHEN m.day = 'Tue' THEN 3
            WHEN m.day = 'Wed' THEN 4
            WHEN m.day = 'Thu' THEN 5
            WHEN m.day = 'Fri' THEN 6
            WHEN m.day = 'Sat' THEN 7
            ELSE 0 END) AS HIDDEN ORD ");
        $query->orderBy('ORD', 'ASC');
        $query->addOrderBy('m.hours', 'ASC');

        if (isset($data['daysNumber'])) {
            $weeksDays = $this->getWeekDays($data);
            $query->where("m.day IN(:weekDays)");
            $query->setParameter('weekDays', array_values($weeksDays));
        }

        return $query->getQuery()->execute();
    }

    /**
     * @param $data
     * @return array
     */
    protected function getWeekDays($data)
    {
        $fromDate = new \DateTime($data['date']);
        $fromDate->modify('+'. $data['daysNumber']+1 .' day');
        $toDate = clone $fromDate;
        $toDate->modify('+'. $data['daysNumber'] .' day');
        $days = [];

        for ($date = $fromDate; $date < $toDate; $date->modify('+1 day')) {
            array_push($days, $date->format('D'));
        }

        return $days;
    }

}
