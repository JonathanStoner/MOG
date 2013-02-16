<?php
class Main extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
	$this->load->model('db_model');
    }
    public function index($function = "home")
    {
//        echo "FUNCTION: $function";      
        switch($function)
        {//UN-PROTECTED AREA
            case "ajax":
                $this->load->view('ajax');
                break;
            case "ajax_test":
                $data['players'] = $this->db_model->get_online_players();
                print_r($data['players']);
//                echo "simple ajax test";
                die();
                break;
            case "test":
                $this->output->enable_profiler(TRUE);
                $this->db_model->test2();
                $data['characters'] = $this->db_model->test();
                $this->load->view('test', $data);
                break;
            case "logout":
                $this->logout_f();
                $this->login_v();
                break;
            default:
                if($this->handle_login_f())
                {//PROTECTED AREA
                    switch($function)
                    {
                        case "game":
                            $this->game_v();
                            break;
                        case "game-online_players_u":
                            $players = $this->db_model->get_online_players();
                            foreach($players as $player):
                                echo "<li>$player[name]</li>";
                            endforeach;
                            break;
                        case "game-chat_log_u":
                            //get messages
                            $messages = $this->db_model->get_messages(10);
                            //return messages
                            $count = count($messages);
                            for ($ctr = $count-1; $ctr >= 0; $ctr--) {
                                $message = $messages[$ctr];
                                echo "<li><span class=\"chat_name\">$message[time] -- $message[chat_name]:</span>&nbsp$message[text]</li>";
                            }
                            break;
                        case "game-chat_log_u-p":
                            //save new message
                            $this->db_model->add_message($_POST['message']);
                            break;
                    }
                }
                else
                {//LOGIN FOR PROTECTED AREA
                    $this->login_v();
                }
        }
    }
    private function login_v()
    {
        $this->load->view('login');
    }    
    private function game_v()
    {
        $data['players'] = $this->db_model->get_online_players();
        $this->load->view('game', $data);
    }    
            
    ///////////////////////////////////////////////
    //           UTILITY FUNCTIONS               //
    ///////////////////////////////////////////////
    private function handle_login_f($un = NULL, $pw = NULL)
    {
        $valid_login = FALSE;
        if($un !== NULL && $pw !== NULL)
        {
           $valid_login = $this->db_model->check_login($un,$pw);
        }
        else if(isset($_COOKIE["username"]) && isset($_COOKIE["password"]))
        {//Cookie Login
           $un = $_COOKIE["username"];
           $pw = $_COOKIE["password"];
           $valid_login = $this->db_model->check_login($un,$pw);
        }
        if(!$valid_login)
        {//Post Login
           $this->load->helper('url');
           $un = $this->input->post('username', TRUE);
//           $pw = md5($this->input->post('password', TRUE));
           $pw = $this->input->post('password', TRUE);
           $valid_login = $this->db_model->check_login($un,$pw);
        }       
        if($valid_login)
        {//save valid login data in cookies
            $expire = time()+60*60*24;//cookies will expire in 1 day
            setcookie("username",$un,$expire);
            setcookie("password",$pw,$expire);

            //not entirely advisable... but it is a working solution...
            $_COOKIE['username'] = $un;
            $_COOKIE['password'] = $pw;
            $this->db_model->set_online();
        }
        return $valid_login;
    }
    private function logout_f()
    {
        $this->db_model->set_offline();
        setcookie("username","",time()-3600);//remove username cookie
        setcookie("password","",time()-3600);//remove password cookie
    }
}
?>
