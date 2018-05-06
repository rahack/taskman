<?php

namespace Controllers;

use App;

class Tasks extends \App\Controller
{
    public function add()
    {
        if (isset($_POST['name'])) {
            $data['name'] = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $data['email'] = $_POST['email'];
        }
        if (isset($_POST['text'])) {
            $data['text'] = $_POST['text'];
        }

        $data['photo'] = '';
        if (isset($_FILES['file'])) {
            $allowed =  array('gif', 'png', 'jpg');
            $filePath = $_FILES['file']['name'];
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
            if(in_array($ext,$allowed) ) {
                $dir = dirname(dirname(__FILE__)) . '/public/uploads/';
                $uploaddir = $dir;
                $fileName = basename($filePath);
                $uploadfile = $uploaddir . $fileName;
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                    $data['photo'] = $fileName;
                }
                $this->_resizeImage($uploadfile, '320', '240', $ext);
            }
        }

        \Models\Tasks::add($data);
        header('Location: /');
    }

    public function edit()
    {
        $login = App::$auth->getLogin();
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        if (!$id || !$login) {
            header('Location: /');
        }
        $row = \Models\Tasks::getOne($id);
        return $this->render('edittask', array('row' => $row[0]));
    }

    public function update() {

        if (isset($_POST['id'])) {
            $data['id'] = $_POST['id'];
        }

        if (isset($_POST['text'])) {
            $data['text'] = $_POST['text'];
        }

        $data['status'] = '0';
        if (isset($_POST['status']) && $_POST['status'] == 'on') {
            $data['status'] = '1';
        }

        \Models\Tasks::update($data);
        header('Location: /');
    }

    private function _resizeImage($file, $w, $h, $ext) {
        list($width, $height) = getimagesize($file);
        $r = $width / $height;

        if ($w/$h < $r) {
            $newheight = $w/$r;
            $newwidth = $w;

            $imagecreate = 'imagecreatefrom';
            $imageout = 'image';
            if ($ext === 'jpg') {
                $imagecreate .= 'jpeg';
                $imageout .= 'jpeg';
            } else {
                $imagecreate .= $ext;
                $imageout .= $ext;
            }
            $src = $imagecreate($file);
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

            $imageout($dst, $file);
        }
    }
}