<?php
namespace controllers;
use models\Model;
use models\User;
//include_once ROOT.'/models/Model.php';
//include_once ROOT.'/models/User.php';

class MainController {
    
    public function actionForm(){

        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 

	$valid_firstName = '';
	$valid_lastName = '';
	$valid_email = '';
	$valid_dateofbirth = '';
	$valid_usersex = '';
	if(isset($_POST['submit']))
	{
            $firstName = trim($_REQUEST['firstName']);
            $lastName = trim($_REQUEST['lastName']);
            $email = trim($_REQUEST['email']);
            $usersex = trim($_REQUEST['usersex']);
            $dateofbirth = trim($_REQUEST['dateofbirth']);
            //$nc = strip_tags($nc);

            if(empty($firstName))
            //echo"Указать имя, фамилию и email";
            //print "<font color=\"red\">* Указать имя, фамилию и email</font> <br>";
            $valid_firstName = 'error';
            //Валидация e-mail адреса, используя функцию filter_var()
            if(empty($lastName)) $valid_lastName = 'error';

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //echo "E-mail указан неверно.<br>";
    		$valid_email = 'error';
            }
                
            Model::insertIntoClientTableDB($firstName,$lastName,$email,$usersex,$dateofbirth);
            // Если корректны, устанавливаем значение сессии в YES
            // Инициируем сессию
  		
            $_SESSION["Login"] = "YES";
		
	}
        require_once (ROOT.'/views/form.php');
        return true;
    }
    
    public function actionPogodazp(){
        
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
        if ($_SESSION["Login"] === "YES") {
            $result = $this->getWebPage("http://www.gismeteo.ua/city/daily/5093/");
        
            if (($result['errno'] != 0 )||($result['http_code'] != 200))
            {
                echo $result['errmsg'];
            }
            else
            {
                $page = $result['content'];
                //echo $page;
                preg_match('/<dd class=\'value m_temp c\'>(.*?)<\/dd>/',$page, $temp);
                preg_match('/<dd class=\'value m_wind ms\' style=\'display:inline\'>(.*?)<\/dd>/',$page, $wind_ms);
                preg_match('/<dd class=\'value m_press torr\'>(.*?)<\/dd>/',$page, $press);
                preg_match('/<div class="wicon hum" title="Влажность">(.*?)<\/div>/',$page, $wicon_hum);
                preg_match('/<dd class="value m_temp c">(.*?)<\/dd>/',$page, $temp_water);
                // выведет примерно следующее: Monday 8th of August 2005 03:12:46 PM
                date_default_timezone_set('Europe/Kiev');
                $today = date('l jS \of F Y H:i:s A');

            }
        }
        require_once (ROOT.'/views/pogodazp.php');
        return true;
    }
    
    public function actionFeedback(){
        $capcha = false;
        
        if(!isset($_SESSION)) 
        { 
            session_start(); 
        } 
        if ($_SESSION["Login"] === "YES") {
            require_once (ROOT.'/views/feedback.php');
            
            // Переменные для формы
            $name = false;
            $emailFrom = false;
            $subject = false;
            $comments = false;
            $dateNaw = false;

            // Обработка формы
            //Если форма отправлена
            if(isset($_POST['submitcallback'])) {
                if (isset($_POST['capcha'])) {
                    $capcha =  $_POST['capcha'];
                }
                // Если форма отправлена 
                // Получаем данные из формы
                $name = $_POST['contactname'];
                $emailFrom = $_POST['email'];
                $subject = $_POST['subject'];
                $comments = $_POST['message'];
                //Время отправки обратного сообщения
                date_default_timezone_set('Europe/Kiev');
                $dateNaw = date('Y-m-d H:i:s');

                // Флаг ошибок
                $errors = false;

                // Валидация полей
                if (!User::checkName($name)) {
                    $errors[] = 'Имя не должно быть короче 2-х символов';
                }
                if (!User::checkEmail($emailFrom)) {
                    $errors[] = 'Неправильный email';
                }
                if (!User::checkSubject($subject)) {
                    $errors[] = 'Тема не должна быть короче 2-х символов';
                }
                if (!User::checkMessage($comments)) {
                    $errors[] = 'Оставьте комментарий';
                }
                if ($errors == false) {
                    // Если ошибок нет
                    $emailTo = 'forestmay@mail.ru'; //email сайта
                    $body = "Name: $name \n\nEmail: $emailFrom \n\nSubject: $subject \n\nCommenits:\n $comments";
                    $headers = 'From: My Site <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $emailFrom;
                    if($capcha != $_SESSION['capcha']){
                        echo "сессия: ".$_SESSION['capcha'];
                        echo "Введено: ".$capcha;
                        echo "Текст с картинки введен не верно!";
                    }
                    else {
                        if (mail($emailTo, $subject, $body, $headers)) {
                            $string = "Сообщение отправлено";
                            echo '<script type="text/javascript">alert("' . $string . '");</script>';
                            //Вставляем данные, подставляя их в запрос
                            Model::insertIntoFeedbackTableDB($name,$emailFrom,$comments,$dateNaw);
                        }
                        else {
                           echo "<h3>При отправке сообщения возникла ошибка</h3>";
                        }

                    }
                }
            }
        }
        else{
            echo 'нет сессиии!!!!!';
        }   
        //require_once (ROOT.'/views/feedback.php');
        return true;
    }
    
    public function actionFeedbacklist(){
        //Получаем список фидбеков
        $res = Model::getFeedbackList();
        require_once (ROOT.'/views/feedbacklist.php');
        return true;
    } 
    
    private function getWebPage($url)
    {
	$ch = curl_init( $url );
	curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
	curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
	curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
	//curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
	curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа

	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	$header['errno']   = $err;
	$header['errmsg']  = $errmsg;
	$header['content'] = $content;
	return $header;
    }

}

