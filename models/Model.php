<?php

class Model {
    
    public static function getFeedbackList(){
        // Соединение с БД
        /*$db = Db::getConnection();
        //Запрос в БД
        $sql = "SELECT * FROM Feedback";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->execute();
        return $result;*/
        
                // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "SELECT * FROM Feedback";

        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        //$result->bindParam(':count', $count, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        $result->setFetchMode(PDO::FETCH_ASSOC);
        
        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $feedbackList = array();
        while ($row = $result->fetch()) {
            $feedbackList[$i]['id'] = $row['id'];
            $feedbackList[$i]['Name'] = $row['Name'];
            $feedbackList[$i]['Email'] = $row['Email'];
            $feedbackList[$i]['Message'] = $row['Message'];
            $feedbackList[$i]['date'] = $row['date'];
            $i++;
        }
        return $feedbackList;
    }

    /**
     * Returns simple news item with specified id
     * @param integer $id
     */
    public static function insertIntoFeedbackTableDB($name,$emailFrom,$comments,$dateNaw){
        
        // Соединение с БД
        $db = Db::getConnection();
        //Запрос в БД
        $sql = "INSERT INTO Feedback(Name, Email, Message, date) 
    		VALUES (:Name, :EmailForm, :Message, :date)";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':Name', $name, PDO::PARAM_STR);
        $result->bindParam(':EmailForm', $emailFrom, PDO::PARAM_STR);
        $result->bindParam(':Message', $comments, PDO::PARAM_STR);
        $result->bindParam(':date', $dateNaw, PDO::PARAM_STR);
        return $result->execute();
    }
    
    /**
     * insert data Into Client Table of DB
     */
    public static function insertIntoClientTableDB($firstName,$lastName,$email,$usersex,$dateofbirth){

        // Соединение с БД
        $db = Db::getConnection();
        //Запрос в БД
        $sql = "INSERT INTO client(firstName, lastName, email, usersex, date) 
    		VALUES (:firstName, :lastName, :email, :usersex, :date)";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $result->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':usersex', $usersex, PDO::PARAM_STR);
        $result->bindParam(':date', $dateofbirth, PDO::PARAM_STR);
        return $result->execute();
    }

}

