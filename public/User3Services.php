<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class User3Service{
    use ConsumesExternalService;
    /**
     * The base uri to consume the User3 Service
     * @var string
     */
    public $baseUri;

    public function __construct()
    {
        $this->baseUri = config('services.users3.base_uri');
    }

    /**
    * Obtain the full list of Users from User3 Site
    * @return string
    */
    public function obtainUsers3()
    {
        return $this->performRequest('GET','/users'); 
    }

    /**
    * Create one user using the User3 service
    * @return string
    */
    public function createUser3($data)
    {
        return $this->performRequest('POST', '/users', $data);
    }

    /**
    * Obtain one single user from the User3 service
    * @return string
    */
    public function obtainUser3($id)
    {
        return $this->performRequest('GET', "/users/{$id}");
    }

    /**
    * Update an instance of user1 using the User3 service
    * @return string
    */
    public function editUser3($data, $id)
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