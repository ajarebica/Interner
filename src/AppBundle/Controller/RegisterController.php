<?php

namespace AppBundle\Controller;

use AppBundle\Form\EmployeeType;
use AppBundle\Form\SearchType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Salary;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class RegisterController extends Controller
{   
    private $data;
    /**
     * @Route("/register", name="register")
     * @Method({"POST","GET"})
     */
    public function registerAction(Request $request)
    {   

        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $employee = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();
            return $this->redirectToRoute('newEmployee');
        }

        return $this->render(
            'interner/register.html.twig',
            array('register_form' => $form->createView(), 'title' => "Registration Form")
        );
    }
           
    /**
     * @Route("/newEmployee", name="newEmployee")
     * @Method({"GET","HEAD"})
     */
    public function showAction()
    {

        $form = $this->createForm(SearchType::class);
        $em = $this->getDoctrine()->getManager();
        $records = $em->getRepository("AppBundle\Entity\Employee")->findAll();
        //$employees = $this->getDoctrine()->findAll();
   
        $templating = $this->container->get('templating');
        $html = $templating->render('interner/newEmployee.html.twig',array('employees' => $records, 'search_form' => $form->createView()));
        return new Response($html);
    }



    /**
     *
     * @Route("/{id}/entity-update", requirements={"id" = "\d+"}, name="update")
     * @return RedirectResponse
     *
     */
    public function updateAction(Request $request,$id)
    {

    if (is_null($id)) {
        $postData = $request->get('employee');
        $id = $postData['id'];
    }

    $em = $this->getDoctrine()->getManager();
    $employee = $em->getRepository('AppBundle\Entity\Employee')->find($id);
    $old_salary=$employee->getSalary();
    $form = $this->createForm(EmployeeType::class, $employee);

    if ($request->getMethod() == 'POST') {
        $form->handleRequest($request);

        if ($form->isValid()) {
  
            $logger = $this->get('logger');

            $logger->info($old_salary);
            $employee = $form->getData();
            if($old_salary!=$employee->getSalary()){
              $this->saveSalary($request,$id);  
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();
            return $this->redirectToRoute('newEmployee');
        }
    }

     return $this->render(
            'interner/register.html.twig',
            array('register_form' => $form->createView(), 'title' => "Update Form", 'employee' => $employee));   
    }


    /**
     *
     * @Route("/{id}/entity-remove", requirements={"id" = "\d+"}, name="delete")
     * @return RedirectResponse
     *
     */
    public function deleteActionName(Employee $employee)
    {
        if (!$employee) {
            throw $this->createNotFoundException('No employee found');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($employee);
        $em->flush();

        $records = $em->getRepository("AppBundle\Entity\Employee")->findAll();
        return $this->redirectToRoute('newEmployee');
    }

    /**
     *
     * @Route("/{id}/entity-contract", requirements={"id" = "\d+"}, name="contract")
     * @return RedirectResponse
     *
     */
    public function finishContract(Request $request,$id)
    {

    if (is_null($id)) {
        $postData = $request->get('employee');
        $id = $postData['id'];
    }

    $em = $this->getDoctrine()->getEntityManager();
    $employee = $em->getRepository('AppBundle\Entity\Employee')->find($id);
    $employee->setEndDate();
    $em = $this->getDoctrine()->getManager();
    $em->persist($employee);
    $em->flush();

    return $this->redirectToRoute('newEmployee');
    }


    /**
     *
     * @Route("/{id}/salary-update", requirements={"id" = "\d+"}, name="salary")
     * @return RedirectResponse
     *
     */
    public function saveSalary(Request $request,$id)
    {
        if (is_null($id)) {
            $postData = $request->get('employee');
            $id = $postData['id'];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $employee = $em->getRepository('AppBundle\Entity\Employee')->find($id);
        $salary= new Salary();
        $salary->setUserId($employee->getId());
        $salary->setSalary($employee->getSalary());
        $em = $this->getDoctrine()->getManager();
        $em->persist($salary);
        $em->flush();

        return $this->redirectToRoute('newEmployee');
    }

    /**
     *
     * @Route("/search", name="search")
     * @param Request $request
     */

    public function handleSearch(Request $request)
    {
        $request_array = $request->request->get('search');
        $string = current($request_array);
        $search_result = array();
        $em = $this->getDoctrine()->getEntityManager();
        $employees = $em->getRepository('AppBundle\Entity\Employee')->findAll();
 
        foreach ($employees as $employee) {
           if ($employee->getStartDate()->format('d-m-Y')==$string && (preg_match('#[0-9]#',$string)))
            {
                $records=$em->getRepository("AppBundle\Entity\Employee")->find($employee->getId());
                $search_result[]=$employee;
            }
            elseif ($employee->getFullName()==$string) 
            {
                $employee=$em->getRepository("AppBundle\Entity\Employee")->find($employee->getId());
                $search_result[]=$employee;
            } 
        }
        $form = $this->createForm(SearchType::class);
        $templating = $this->container->get('templating');
        $html = $templating->render('interner/newEmployee.html.twig',array('employees' => $search_result, 'search_form' => $form->createView()));
        return new Response($html);
    }
}