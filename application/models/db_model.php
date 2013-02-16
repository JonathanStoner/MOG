<?php
class Db_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }
    
    public function test()
    {
        $this->db->select('*');
        $this->db->from('characters');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function test2()
    {
/** /
        $this->db->select('*');
        $this->db->from('characters');
        $query = $this->db->get();
        $ret = $query->result_array();
        print_r($ret);
        
        $this->db->select('*');
        $this->db->from('characters');
        $this->db->where('characters.character_id', '1');
        $query = $this->db->get();
        $ret2 = $query->row_array();
        print_r($ret2);
/** /
   $link = mysql_connect("mysql", "Qazebulon", "123qweasdzxc");
//   $link = mysql_connect("mysql", "MOG", "123qweasdzxc");
   mysql_select_db("MOG");

   $query = "SELECT * FROM characters";
   $result = mysql_query($query);
//   print_r($result);

/** /
   while ($line = mysql_fetch_array($result))
   {
      print_r($line);
 //     foreach ($line as $value)
 //      {
 //        print "$value<br>";
 //     }
   }
/** /
   foreach($result as $line):
      echo "$line<br>";
   endforeach;
/** /
   
   mysql_close($link);
/**/
        $query = 'SELECT * FROM characters';
        $result = $this->db->query($query);
        $result2 = $result->result_array();
        print_r($result);
        print_r($result2);
    }

    
    private function get_current_user()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $_COOKIE['username']);
        $this->db->where('password', $_COOKIE['password']);
        $query = $this->db->get();
        return $query->row_array();
    }
    private function get_current_player()
    {
        $user = $this->get_current_user();
        $this->db->select('*');
        $this->db->from('characters');
        $this->db->where('characters.character_id', $user['character_id']);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function check_login($un, $pw)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $un);
        $this->db->where('password', $pw);
        $query = $this->db->get();
        $count = $query->num_rows();
        return ($count == 1);
    }
    public function get_online_players()
    {
        $this->db->select('name');
        $this->db->from('users');
        $this->db->join('characters', 'characters.character_id = users.character_id');
        $this->db->where('users.status','online');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function set_online()
    {
        $user = $this->get_current_user();
        $user['status'] = "online";
        $this->db->where('username', $user['username']);
        return $this->db->update('users', $user);
    }
    public function set_offline()
    {
        $user = $this->get_current_user();
        if($user != NULL)
        {
            $user['status'] = "offline";
            $this->db->where('username', $user['username']);
            $this->db->update('users', $user);
        }
    }
    public function add_message($message)
    {
        $player = $this->get_current_player();
        $data = array(
            'chat_name' => $player['name'],
            'text' => $message
        );
        $this->db->insert('messages', $data);
    }
    public function get_messages($limit)
    {
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->order_by("time", "desc");
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
