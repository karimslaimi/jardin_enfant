<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/about", name="aboutus")
     */
    public function aboutAction(){

    }

    /**
     * @Route("/signin", name="user_login")
     */
    public function loginAction(Request $request){
        $username=$request->get('username');
        $password=$request->get('password');

        if($request->isMethod("GET")){
            return $this->render("default/login.html.twig",array("msg"=>""));
        }else{

            // Retrieve the security encoder of symfony
            $factory = $this->get('security.encoder_factory');


            $user_manager = $this->get('fos_user.user_manager');
            //$user = $user_manager->findUserByUsername($username);
            // Or by yourself
            $user = $this->getDoctrine()->getManager()->getRepository("AppBundle:User")
                ->findOneBy(array('username' => $username));
            /// End Retrieve user

            // Check if the user exists !
            if(!$user){
                return $this->render("default/login.html.twig",array("msg"=>"user does not exist"));
            }

            /// Start verification
            $encoder = $factory->getEncoder($user);
            $salt = $user->getSalt();

            if(!$encoder->isPasswordValid($user->getPassword(), $password, $salt)) {
                return $this->render("default/login.html.twig",array("msg"=>"username or password are incorrect"));
            }
            /// End Verification

            // The password matches ! then proceed to set the user in session

            //Handle getting or creating the user entity likely with a posted form
            // The third parameter "main" can change according to the name of your firewall in security.yml
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            // If the firewall name is not main, then the set value would be instead:
            // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
            $this->get('session')->set('_security_main', serialize($token));

            // Fire the login event manually
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

           // $us=$this->container->get('security.token_storage')->getToken()->getUser();

            if ($this->container->get('security.authorization_checker')->isGranted("ROLE_RESPONSABLE")) {
                // SUPER_ADMIN roles go to the `admin_home` route
                return $this->redirectToRoute("tuteur_index");
            }elseif($this->container->get('security.authorization_checker')->isGranted('ROLE_PARENT')) {
                // Everyone else goes to the `home` route
                return $this->redirect("/");
            }

        }
    }





}
