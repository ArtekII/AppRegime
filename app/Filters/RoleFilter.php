<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('is_logged_in')) {
            return redirect()->to(site_url('connexion'))->with('error', 'Veuillez vous connecter.');
        }

        $allowedRoles = $arguments ?? [];
        $userRole = session()->get('user_role');

        if ($allowedRoles !== [] && ! in_array($userRole, $allowedRoles, true)) {
            return redirect()->to(site_url('accueil'))->with('error', 'Acces non autorise.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
