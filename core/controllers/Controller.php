<?php
/**
 * Created by Mota-systems company.
 * Author: Pavel Lamzin
 * Date: 27.03.14
 * Time: 15:51
 * All rights are reserved
 */

namespace controllers;


use main\HttpException;

class Controller
{

    public $template = 'layout';

    public function render($view, array $data = [])
    {
        $output = $this->renderPart($view, $data);

        $output = $this->renderFile($this->getTemplateFile(), ['content' => $output]);

        echo $output;
    }

    public function getView($view)
    {
        $viewPath = VIEW_PATH . $view . '.php';
        if (is_file($viewPath)) {
            return $viewPath;
        } else {
            throw new HttpException("Нет файла представления $viewPath", 500);
        }
    }

    public function renderPart($view, $data)
    {
        $viewFile = $this->getView($view);
        $output   = $this->renderFile($viewFile, $data);

        return $output;
    }

    public function renderFile($file, $data)
    {
        if (!is_array($data))
            throw new HttpException('Данные должны быть переданы в представление в виде массива');
        extract($data, EXTR_PREFIX_SAME, 'data');
        ob_start();
        ob_implicit_flush(FALSE);
        require($file);

        return ob_get_clean();
    }

    public function getTemplateFile()
    {
        $templatePath = VIEW_PATH . DIRECTORY_SEPARATOR . $this->template.'.php';
        if (is_file($templatePath)) {
            return $templatePath;
        } else {
            throw new HttpException("Нет шаблона {$this->template}");
        }
    }

    public function renderText($text){
        echo $this->renderFile($this->getTemplateFile(), ['content'=>$text]);
    }

}