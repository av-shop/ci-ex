<?php

namespace App\Controllers;

use App\Models\mainModel;

class mainController extends BaseController{


public function index(){

    $users = new mainModel();
    $name = $this -> request -> getVar('name');
    $email = $this -> request -> getVar('email');
    $avatar = $this -> request -> getFile('avatar');
    $avatarVal = '';
    $templateParams['params'] = array('usersData' => $users->orderBy('name','ASC')->findAll(), 'header'=>view('templates/header'),'footer'=>view('templates/footer'),'newUser'=>null);

if($name && $email ){

    $checkedEmail = $users->where('email',$email)->first();

    if(! $checkedEmail){

    if ($avatar->isValid()) {
        $avatarVal = $avatar -> getRandomName();
        $avatar -> move('./uploads/',$avatarVal);
        }

    $userData = [
        'name' => $name,'email' => $email, 'avatar'=> $avatarVal
        ];
     
    $users->insert($userData);

    if($users->getInsertID()){
        $templateParams['params']['newUser'] = 'yes';
    }

}else{
$templateParams['params']['newUser'] = 'error';
}


}


return view('home',$templateParams);

 }


public function new_user(){

    $templateParams['header'] = view('templates/header');
    $templateParams['footer'] = view('templates/footer');
    
return view('users/new_user',$templateParams);
}





}
