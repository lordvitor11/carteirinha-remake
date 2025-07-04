<?php
    require_once('../Model/model.php');

    class RelatorioController
    {
        public $model;

        public function __construct()
        {
            $this->model = new Model();
        }

        public function getRelatorioFaltas($day)
        {
            return $this->model->getRelatorioFaltas($day);
        }

        public function getNameById($id)
        {
            return $this->model->getNameById($id);
        }

        public function getCardapioByInterval($inicio, $fim)
        {
            return $this->model->getCardapioByInterval($inicio, $fim);
        }
    }
?>