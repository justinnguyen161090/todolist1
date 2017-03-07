<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function createAction(Request $request)
    {
    	$todo = new Todo;

    	$form = $this->createFormBuilder($todo)
    		->add('fullname',TextType::class, array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px'))) 
    		->add('birth',TextType::class, 
    			array('attr'=>
    				array('class' => 'form-control datetimepicker', 'data-provide' => 'datepicker', 'data-format' => 'dd/mm/yyyy','style'=>'margin-bottom:15px'))) 
    		->add('country',ChoiceType::class, array('choices'=>array('hanoi'=>'Hanoi','Danang'=>'Danang','HCM'=>'HCM'),'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px'))) 
    		->add('university',TextType::class, array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px'))) 
    		->add('phone',NumberType::class, array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px'))) 
    		->add('email',EmailType::class, array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
    		->add('submit',SubmitType::class, array('label'=>'Register','attr'=>array('class'=>'btn btn-primary btn-block')))
    		->getForm();

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form ->isValid())	{
    		//die('success!'); 
    		/*$name = $form['fullname'] -> getData(); 
    		$birth = $form['birth'] -> getData(); 
    		$country = $form['country'] -> getData(); 
    		$university = $form['university'] -> getData(); 
    		$phone = $form['phone'] -> getData(); */
    		$email  = $form['email'] -> getData(); 

    		/*$todo -> setFullname($name);
    		$todo -> setBirth($birth);
    		$todo -> setCountry($country);
    		$todo -> setUniversity($university);
    		$todo -> setPhone($phone);
    		$todo -> setEmail($email);

    		$em = $this->getDoctrine()->getManager();
    		$em->flush();

    		$this->addFlash(
    			'notice',
    			'register success!'
    			);

    		return $this->redirectToRoute('todo_list');*/
    		
    		$mailer = $this->get('mailer');
                $message = $mailer->createMessage()
                    ->setSubject('dang ky thanh cong')
                    ->setFrom('abc@gmail.com')
                    ->setTo($email)
                    ->setBody('dag ky thanh cong');

                $mailer->send($message); 
    	}


        //die('hello'); 
        return $this->render('todo/index.html.twig', array(
        	'form'=>$form->createView() 	
        	));
    }
}