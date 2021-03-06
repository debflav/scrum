<?php


namespace Override\ScrumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DispatchController extends Controller
{

    private $role;

    /**
     * Render the user page following his role (it's better to overwrite
     * the security controller)
     *
     * @Route("/dispatch", name="scrumbundle_dispatch_controller")
     * @Method("GET")
     * @Template()
     */
    public function dispatchAction(Request $request)
    {
        $this->setRole();

        switch ($this->role[0]) {
            case 'ROLE_ADMIN':
                return $this->redirect($this->generateUrl('user'));
                break;
            case 'ROLE_SECRETARY':
                return $this->redirect($this->generateUrl('formation'));
                break;
            case 'ROLE_PROFESSOR':
                return $this->redirect($this->generateUrl('etudiant'));
                break;
            case 'ROLE_STUDENT':
                return $this->redirect($this->generateUrl('etudiant'));
                break;
            default:
                return $this->redirect($this->generateUrl('fos_user_security_login'));
                break;
        }
    }

    /**
     * Remove the unwanted 'ROLE_USER' and set the role to define the redirection
     * Supposed the user has one role.
     */
    private function setRole()
    {
        $this->role = $this->getUser()->getRoles();

        if(in_array('ROLE_USER', $this->role) && count($this->role) > 1) {
            unset($this->role[array_search('ROLE_USER', $this->role)]);
        }
    }

}
