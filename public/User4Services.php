<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class User4Service{
    use ConsumesExternalService;
    /**
     * The base uri to consume the User4 Service
     * @var string
     */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.users4.base_uri');
    }

    /**
    * Obtain the full list of Users from User3 Site
    * @return string
    */
    public function obtainUsers4()
    {
        return $this->performRequest('GET','/users'); 
    }

    /**
    * Create one user using the User4 service
    * @return string
    */
    public function createUser4($data)
    {
        return $this->performRequest('POST', '/users', $data);
    }

    /**
    * Obtain one single user from the User4 service
    * @return string
    */
    public function obtainUser4($id)
    {
        return $this->performRequest('GET', "/users/{$id}");
    }

    /**
    * Update an instance of user1 using the User4 service
    * @return string
    */
    public function editUser4($data, $id)
    {
        return $this->performRequest('PUT', "/users/{$id}", $data);
    }

    /**
    * Remove an existing user
    * @return Illuminate\Http\Response
    */
    public function delete($id)
    {
        return $this->performRequest('DELETE', "/users/{$id}");
    }
}