<?php

namespace AppBundle\Service;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use AppBundle\Entity\Machine;
use AppBundle\Utils\DateCompareHelper;

class EquipmentManager {

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var mixed
     */
    protected $errors;

    /**
     * EquipmentManager constructor.
     * @param EntityManager $em
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManager $em, ValidatorInterface $validator, Serializer $serializer)
    {
        $this->em = $em;
        $this->validator = $validator;
        $this->serializer = $serializer;
    }

    /**
     * @param $data
     */
    public function saveMachine($data)
    {
        $data['hours'] = $data['startHour'] . '-' .$data['endHour'];
        $machine = $this->serializer->deserialize(
            json_encode($data),
            Machine::class,
            'json'
        );

        $this->_validateData($machine);
        $this->_addNewMachine($machine);
    }

    /**
     * @param $data
     * @return array
     */
    public function getTermsByData($data)
    {
        $terms = $this->em->getRepository(Machine::class)->findWithOrderByDays($data);
        $dateCompare = new DateCompareHelper($terms, $data['date']);
        $dateCompare->compareTerms();
        $result = $dateCompare->preparedTerms;

        return $result;
    }

    /**
     * @param $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $machine
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function _addNewMachine(Machine $machine)
    {
        if ($this->errors) {
            return false;
        }

        $this->em->persist($machine);
        $this->em->flush();
    }

    /**
     * @param $data
     */
    protected function _validateData($data)
    {
        $errors= $this->validator->validate($data);

        if (count($errors) > 0) {
            $this->setErrors($errors);
            return;
        }

        $exist = $this->em->getRepository(Machine::class)->findTermInSameDay(
            $data->getName(),
            $data->getDay()
        );

        if ($exist) {
            $this->setErrors('Filled term is in use');
        }

    }
}