<?php
    
    namespace App\Services;

    use App\Entity\Register;
use Symfony\Component\HttpFoundation\Request;

class TraitementRequete
{
    public function processRequest(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $register = new Register();
        $register->setUsername($data['username']);
        $register->setPassword($data['password']);
        $role = $data['role'];

        if (!is_array($role)) {
            $role = explode(',', $role);
        }

        $register->setRole($role);

        return $register;
    }
}
    

