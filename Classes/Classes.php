<?php
require_once "../Classes/DBConnect.php";

class Classmanager {

    public function geturldetails() {
        $con = DBConnect::getConnection();
        $sql = "Select * from `urls` ";
        $result = mysql_query($sql, $con) or die(mysql_error());
        $i=0;
        $url = array();
        while ($row = mysql_fetch_assoc($result)) {
             $url[$i]['id'] = $row["id"];
             $url[$i]['url'] = $row["url"]; 
             $url[$i]['clicks'] = $row["clicks"];
             $i++;
        } 
        mysql_close($con);
        return $url;
    } 
    public function getshorturl($id) {
        $con = DBConnect::getConnection();
        $date = date("Y-m-d");
        $sql = "Select clicks,url from `urls` where id ='$id'";
        $results = mysql_query($sql, $con) or die(mysql_error());
        $row = mysql_fetch_array($results, MYSQL_BOTH);
        $clickcount = $row['clicks'];
        $URL = $row['url'];
        $clicks = $clickcount + 1 ;

        $query = "update urls set clicks='$clicks' where id ='$id'";
        $results = mysql_query($query, $con) or die(mysql_error());

        if ($results) {
            return $URL;
        }
    } 

    public function addurl($url) {
        
        $con = DBConnect::getConnection();
        $date = date("Y-m-d");
        $newurl = mysql_real_escape_string($url);
        $sql = "INSERT INTO urls (url, added_date) VALUES ('$newurl', '$date')";
        $results = mysql_query($sql, $con) or die("couldn't execute the sql");

        if ($results) {
            return 'added';
        } else {
            return 'failed';
        }
    }  

    public function updateclickcount($urlid) {
        
        $con = DBConnect::getConnection();
        $date = date("Y-m-d");
        $newurl = mysql_real_escape_string($url);
        $sql = "Select clicks from `urls` where id ='$urlid'";
        $results = mysql_query($sql, $con) or die(mysql_error());
        $row = mysql_fetch_array($results, MYSQL_BOTH);
        $clickcount = $row['clicks'];

        $clicks = $clickcount + 1 ;

        $query = "update urls set clicks='$clicks' where id ='$urlid'";
        $results = mysql_query($query, $con) or die(mysql_error());

        if ($results) {
            return $clicks;
        } else {
            return false;
        }
    }

    public function register($email,$password) {
        
        $con = DBConnect::getConnection();
        $duplicate = $this->checkduplicate($email,$password);
        if ($duplicate != '1') {
            $date_with_time = date("Y-m-d H:i:s");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $email = mysql_real_escape_string($email);
            $password = mysql_real_escape_string($password);
            $sql = "INSERT INTO user (email, password, added_date) VALUES ('$email', '$hashedPassword', '$date_with_time')";
        
            $results = mysql_query($sql, $con) or die("couldn't execute the sql");

            if ($results) {
                return 'added';
            } else {
                return 'failed';
            }
        }  else {
            return 'duplicate';
        }
    }  

    public function checkduplicate($email,$password) {
        $con = DBConnect::getConnection();

        $query = "SELECT * FROM `user` WHERE `email`='$email' LIMIT 1";
        $results = mysql_query($query, $con) or die(mysql_error());
        $count=mysql_num_rows($results);
            if($count>0){
                    return 1;
            }else{
                return 0;
            }
    }

    public function login($email,$password) {
        
        $con = DBConnect::getConnection();
        $query = "SELECT * FROM `user` WHERE `email`='$email' ";
        $results = mysql_query($query, $con) or die(mysql_error());
        $count=mysql_num_rows($results);
        $row = mysql_fetch_assoc($results);
        $_SESSION['userid'] = $row['userid'];
        $hashedPassword = $row['password'];
       
        if (password_verify($password, $hashedPassword)) {
            return "verified";
        } else {
            return "Incorrect";
        }

    }

    public function createpost ($title ,$body ,$userid) {
        $con = DBConnect::getConnection();
        $duplicate = $this->checkduplicatepost($title);
        if ($duplicate != '1') {
            $date = date("Y-m-d");
            $body = mysql_real_escape_string($body);
            $title = mysql_real_escape_string($title);
            $sql = "INSERT INTO posts (title, body, added_date, added_by) VALUES ('$title', '$body', '$date','$userid')";
            $results = mysql_query($sql, $con) or die("couldn't execute the sql");
            if ($results) {
                return 'added';
            } else {
                return 'failed';
            }
        } else {
            return 'duplicate';
        }
    }
    
    public function checkduplicatepost($title) {
        $con = DBConnect::getConnection();
        $date = date("Y-m-d");
        $query = "SELECT * FROM `posts` WHERE `title`='$title' AND `added_date`='$date' LIMIT 1";
        $results = mysql_query($query, $con) or die(mysql_error());
        $count=mysql_num_rows($results);
            if($count>0){
                return 1;
            }else{
                return 0;
            }
    }
    
    public function getposts($value) {
        $con = DBConnect::getConnection();
        $sql = "SELECT * FROM `posts`";
        if (!empty($value)) {
            $sql .= " WHERE `title` LIKE '%" . mysql_real_escape_string($value) . "%'";
        }
            $result = mysql_query($sql, $con) or die(mysql_error());
            $i=0;
            $post = array();
            while ($row = mysql_fetch_assoc($result)) {
                $rate1 = 0;
                $rate2 = 0;
                $rate3 = 0;
                $rate4 = 0;
                $rate5 = 0;
                $count1 = 0;
                $count2 = 0;
                $count3 = 0;
                $count4 = 0;
                $count5 = 0;
                $roundedRate= 0;  
                $totalrate= 0;  
                $totalcount= 0; 
                $rate= 0;
                $ratearray = $this->getrate($row['id']);
                foreach ($ratearray as $entry) {
                    $rate = $entry['rate'];
                    switch ($rate) {
                        case 1:
                            $rate1++;
                            break;
                        case 2:
                            $rate2++;
                            break;
                        case 3:
                            $rate3++;
                            break;
                        case 4:
                            $rate4++;
                            break;
                        case 5:
                            $rate5++;
                            break;
                    }
                }
                $count1 = $rate1 * 1; 
                $count2 = $rate2 * 2; 
                $count3 = $rate3 * 3; 
                $count4 = $rate4 * 4; 
                $count5 = $rate5 * 5; 
                $totalcount = $count1 + $count2 + $count3 + $count4 + $count5;
                $totalrate = $rate1 + $rate2 + $rate3 + $rate4 + $rate5;
                if ($totalrate > 0) {
                    $rate = $totalcount / $totalrate;
                    $roundedRate = ceil($rate);
                }
                $post[$i]['id'] = $row['id'];
                $post[$i]['title'] =$row['title'];
                $post[$i]['body'] = $row['body'];
                $post[$i]['rate'] = $roundedRate;
                 $i++;
            } 
            return $post;
    }

    public function getpostdata($id) {
        $con = DBConnect::getConnection();
        $sql = "SELECT * FROM `posts` where `id` = '$id'";
            $result = mysql_query($sql, $con) or die(mysql_error());
            $row = mysql_fetch_assoc($result);
                $post['id'] = $row['id'];
                $post['title'] =$row['title'];
                $post['body'] = $row['body'];
            mysql_close($con);
            return $post;
    }   

    public function addcomment($comment,$id,$userid) {
        
        $con = DBConnect::getConnection();
            $date_with_time = date("Y-m-d H:i:s");
            $comment = mysql_real_escape_string($comment);
            $sql = "INSERT INTO comments (postid, comment, added_date, added_by) VALUES ('$id', '$comment', '$date_with_time', '$userid')";
            $results = mysql_query($sql, $con) or die("couldn't execute the sql");

            if ($results) {
                return 'commentadded';
            } else {
                return 'failed';
            }
        
    } 
    public function getcomments($id,$userid) {
        $con = DBConnect::getConnection();
        $sql = "SELECT c.*, u.email FROM `comments` c LEFT JOIN user u  on u.userid=c.added_by where c.postid = '$id' AND c.status = '1' AND c.added_by='$userid'";
            $result = mysql_query($sql, $con) or die(mysql_error());
            $i=0;
            $post = array();
            while ($row = mysql_fetch_assoc($result)) {
                $post[$i]['id'] = $row['id'];
                $post[$i]['comment'] =$row['comment'];
                $post[$i]['email'] = $row['email'];
                 $i++;
            } 
            mysql_close($con);
            return $post;
    }

    public function deletecomments($id) {
        $con = DBConnect::getConnection();
        $sql = "update `comments` set status ='2' where id ='$id'";
            $result = mysql_query($sql, $con) or die(mysql_error());
            if ($result) {
                $post = 'deleted';
            } else {
                $post = 'failed';
            }
            mysql_close($con);
            return $post;
    }
    
    public function updaterate($id,$rate,$userid) {
        $con = DBConnect::getConnection();
        $date = date("Y-m-d H:i:s");
        $sql = "INSERT INTO rating (postid, rate, added_date, added_by) VALUES ('$id', '$rate', '$date', '$userid')";
        $result = mysql_query($sql, $con) or die("couldn't execute the sql");
            if ($result) {
                $post = 'rateadded';
            } else {
                $post = 'failed';
            }
            mysql_close($con);
            return $post;
    }
    
    
    public function getrate($id){
         $con = DBConnect::getConnection();
        $sql = "SELECT * FROM `rating` where `postid` = '$id'";
        $result = mysql_query($sql, $con) or die(mysql_error());
            $i=0;
            $post = array();
            while ($row = mysql_fetch_assoc($result)) {
                $post[$i]['postid'] = $row['postid'];
                $post[$i]['rate'] =$row['rate'];
                 $i++;
            } 
            mysql_close($con);
            return $post;
    }
    
    public function getweatherdata($city) {
    
        if ($city != '') {
            $data = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=ed5bcbbbe0d11340d34e2148b92f2a23");
            $weather = json_decode($data,true);
            $tempInCel = intval($weather['main']['temp'] - 273);


            $fullWeather = "The weather in ".$city." is ".$weather['weather'][0]['main']." and tempture is ".$tempInCel." C";

        }
        return $fullWeather;
    }
    
}


?>