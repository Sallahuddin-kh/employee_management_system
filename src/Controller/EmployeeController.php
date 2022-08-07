<?php
// src/Controller/TaskController.php
namespace App\Controller;

use App\Entity\Employee;
use App\Form\Type\EmployeeSignUpType;
use App\Form\Type\EmployeeLoginType;
use PhpParser\Node\Name;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee_signup", name="employee_signup")
     */
    public function signup(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeSignUpType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $employee = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employee_sigup');
        }
        return $this->render('employee/employee.html.twig', [
            'form' => $form->createView(),
            'error_message' => null
        ]);
    }
    /**
     * @Route("/employee_login", name="employee_signin")
     */
    public function login(Request $request, SessionInterface $session): Response
    {
        $employee = $session->get('employee');
        if($employee){
            return $this->render('employee/employee_dashboard.html.twig', [
                'employee' => $employee,
            ]);
        }
        $form = $this->createForm(EmployeeLoginType::class);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(Employee::class);
        if ($form->isSubmitted() && $form->isValid()) {
            $form_data = $form->getData();
            $Employee = $repository->findOneBy([
                'Name' => $form_data['Name'],
            ]);
            if($Employee != null){
                $session->set('employee', $Employee);
                $employee = $session->get('employee');
                return $this->render('employee/employee_dashboard.html.twig', [
                    'employee' => $employee,
                ]);
            }
            else{
                return $this->render('employee/employee.html.twig', [
                    'form' => $form->createView(),
                    'error_message' => 'Incorrect Credentials'
                ]);
            }
        }
        return $this->render('employee/employee.html.twig', [
            'form' => $form->createView(),
            'error_message' => null
        ]);
    }
    /**
     * @Route("/employee_logout", name="employee_logout")
     */
    public function logout(Request $request, SessionInterface $session): Response
    {
        $session->remove('employee');
        return $this->redirectToRoute('employee_signin');
    }
    /**
     * @Route("/employee_list", name="employee_list")
     */
    public function employeelist(Request $request, SessionInterface $session): Response
    {
        $repository = $this->getDoctrine()->getRepository(Employee::class);
        $Employee = $repository->findAll();
        var_dump($Employee);
        return $this->render('employee/employee_list.html.twig', [
            'employees'=> $Employee
        ]);
    }

}
