<?php
/**
 * Created by PhpStorm.
 * User: bartek
 * Date: 23.08.18
 * Time: 10:28
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpKernel\Exception\HttpException;

class EquipmentController extends FOSRestController
{
    /**
     * @View
     * @Route("/api/equipment/add")
     * @Method({"POST"})
     * @RequestParam(name="name")
     * @RequestParam(name="day")
     * @RequestParam(name="startHour")
     * @RequestParam(name="endHour")
     */
    public function addAction(ParamFetcher $fetcher)
    {
        $data = $fetcher->all();
        $equipmentManager = $this->get('app.equipment_manager');
        $equipmentManager->saveMachine($data);
        $errors = $equipmentManager->getErrors();

        if ($errors) {
            throw new HttpException(400, "Object has errors: " .(string) $errors);
        }

        $view = $this->view(['Machine successfully added'], 200);

        return $this->handleView($view);
    }

    /**
     * @View
     * @Route("/api/equipment/show")
     * @Method("GET")
     * @QueryParam(name="date")
     * @QueryParam(name="daysNumber", requirements="\d+", default="1")
     */
    public function showAction(ParamFetcher $fetcher)
    {;
        $data = $fetcher->all();
        $equipmentManager = $this->get('app.equipment_manager');
        $terms = $equipmentManager->getTermsByData($data);
        $view = $this->view($terms, 200);

        return $this->handleView($view);
    }
}