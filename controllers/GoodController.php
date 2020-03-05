<?php
namespace App\controllers;

use App\models\Good;
//use App\controllers\Controllers;

class GoodController extends Controllers 
{
    public function indexAction()
    {
        return $this->render('home');
    }

    public function oneAction()
    {
        $id = (int)$_GET['id'];
        $good = Good::getOne($id);
        return $this->render(
            'good',
            [
                'good' => $good,
                'title' => 'Католог товаров',
            ]
        );
    }

    public function allAction()
    {
        $goods = Good::getAll();
        return $this->render(
            'goods',
            [
                'goods' => $goods,
                'title' => 'Католог товаров',
            ]
        );
    }

    public function addAction() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $good = new Good();
            $good->setName($_POST['name']);
            $good->setInfo($_POST['info']);
            $good->setPrice($_POST['price']);
            $good->save();
            
            header('location: /?c=good&a=all');
            return '';
        }

        return $this->render('addGood');
    }
}
