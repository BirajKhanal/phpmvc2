<?php
class Users extends Controller
{
    public function __construct()
    {
        //load user model here
        $this->userModel = $this->model('User');
    }

    //default method 
    public function index()
    {
    }


    public function login()
    {

        $validation = new Validation;

        $validation_rules = [
            'email' => [
                'display' => 'Email',
                'required' => true,
                'valid_email' => true,
                'max' => 150
            ],
            'password' => [
                'display' => 'Password',
                'required' => true,
                'min' => 6
            ]
        ];
        
        //post init
        $post = [
            'email' => '',
            'password' => ''
        ];

        //check is data is being posted
        if ($_POST) {
            //process login request              

            //validation check
            $validation->check($_POST, $validation_rules);

            //confirm all error messages are empty
            if ($validation->passed()) {
                //validated
                if ($this->userModel->findUserByEmail($_POST['email'])) {
                    //check and set logged in user
                    $loggedInUser = $this->userModel->login($_POST['email'], $_POST['password']);
                    if ($loggedInUser) {
                        //create session for the user
                        createUserSession($loggedInUser);
                    } else {
                        $validation->addError("Somthing is wrong with your eamil or password");
                    }
                } else {
                    //load view with error messages
                    $validation->addError("Email not found");
                    // $this->view('users/login', $data);
                }
            }

            //if POST then send this
            $post = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
            ];
        }

        //value passed in view 
        $data = [
            'post' => $post,
            'display_error' => $validation->displayErrors()
        ];

        $this->view('users/login', $data);
    }


    public function register()
    {

        //create validation object
        $validation = new Validation;

        //init post
        $post = [
            'name' => '',
            'email' => '',
            'password' => '',
            'confirm_password' => '',
        ];

        //create validation rule

        $validation_rules = [
            'name' => [
                'display' => 'Name',
                'required' => true,
                'min' => 3,
                'max' => 150,
                'alphabetic' => true
            ],
            'email' => [
                'display' => 'Email',
                'required' => true,
                'valid_email' => true,
                'max' => 150
            ],
            'password' => [
                'display' => 'Password',
                'required' => true,
                'matches' => 'confirm_password',
                'min' => 6
            ],
            'confirm_password' => [
                'display' => 'Confirm Password',
                'required' => true,
                'min' => 6
            ]
        ];

        //check id data is being posted
        if ($_POST) {
            //process register request

            //check validation
            $validation->check($_POST, $validation_rules);

            //check if email already exists
            if ($this->userModel->findUserByEmail($_POST['email'])) {
                $validation->addError('Entered email is already registerd');
            }

            //if validation sucess
            if ($validation->passed()) {

                //validated
                //hash password before storing
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                //register user in the database
                if ($this->userModel->register($_POST)) {
                    //if error free
                    redirect('users/login');
                } else {
                    $validation->addError("Could not register");
                }
            }
            //store in post
            $post = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
            ];
        }
        //this is data to be sent to view
        $data = [
            'post' => $post,
            'display_error' => $validation->displayErrors()
        ];

        //load the register view
        $this->view('users/register', $data);
    }

    //logout the currrent user
    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        session_destroy();
        redirect('users/login');
    }
}
