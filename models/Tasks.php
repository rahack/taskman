<?php

namespace Models;

use App;

class Tasks extends \App\Model
{
    public static function add($data)
    {
        $db = App::$db;
        $db->execute("insert into tasks set name = :name, email = :email, text = :text, photo = :photo",
            array(
                'name' => $data['name'],
                'email' => $data['email'],
                'text' => $data['text'],
                'photo' => $data['photo']
                )
        );
    }

    public static function update($data)
    {
        $db = App::$db;
        $db->execute("UPDATE tasks SET text = :text, status = :status where id = :id",
            array(
                'text' => $data['text'],
                'status' => $data['status'],
                'id' => (int)$data['id'])
        );
    }

    public static function getAll()
    {
        $db = App::$db;
        return $db->execute("SELECT * FROM tasks");
    }

    public static function getOne($id)
    {
        $db = App::$db;
        return $db->execute("SELECT * FROM tasks where id=" . $id);
    }
}