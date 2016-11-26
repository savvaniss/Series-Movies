<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\Controller;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
    public function getSignUp($request, $response){
        return $this->view->render($response, 'auth/signup.twig');

    }
    public function postSignUp($request, $response){

        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'name' => v::notEmpty()->alpha(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);

        if ($validation->failed())
        {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = User:: create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            'token' => bin2hex(random_bytes(32))
        ]);

        $url = $this->router->pathFor('auth.verify', ['id' => $user->id, 'code'=> $user->token]);
        $path =$request->getUri()->withPath($url);
        $message = "     
                      Hello $user->name,
                      <br /><br />
                      Welcome to Series!<br/>
                      To complete your registration  please , just click following link<br/>
                      <br /><br />
                      <a href='$path'>$path</a>
                      <br /><br />
                      Thanks";

        $this->msg->sendMail($user->email, $message, 'Verification Email');
        $this->flash->addMessage('info', 'You have been signed up. A verification email has been sent to you. Please follow the link in your email to Activate your account.');

        return $response->withRedirect($this->router->pathFor('home'));

    }

    public function getSignIn($request, $response){
        return $this->view->render($response, 'auth/signin.twig');
    }
    public function postSignIn($request, $response){
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );
        if (!$auth){
            if (isset($_SESSION['errors'])) {
                $this->flash->addMessage('error', $_SESSION['errors']);
                return $response->withRedirect($this->router->pathFor('auth.signin'));
            }
            $this->flash->addMessage('error', 'Could not sign you in with those details. Please try again.');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignOut($request, $response){
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getVerify($request, $response, $args){

        if(empty($args['id'])) {
            $this->flash->addMessage('error', 'Your Id is missing.');
            return $this->view->render($response, 'auth/verification.twig');
        }
        if (!empty($args['id']) && empty($args['code'])) {
                $this->flash->addMessage('error', 'Your Token is missing.');
                return $this->view->render($response, 'auth/verification.twig');
        }
        
        $validation = $this->validator->validateArray($args, [
            'id' => v::numeric()->positive()->idExist(),
            'code' => v::alnum()->codeExist(),
        ]);

        if ($validation->failed())
        {
            $this->flash->addMessage('error', 'Wrong Id or Token.');
            return $this->view->render($response, 'auth/verification.twig');
        }

        $user = new User;
        $returnUser = $user->where('id', $args['id'])->first();
        $returnUser->setVerified($args['id'], $args['code']);
        $this->flash->addMessage('info', 'Your account has verified. You can now Sign In');
        return $this->response->withRedirect($this->router->pathFor('auth.signin'));
    }
}