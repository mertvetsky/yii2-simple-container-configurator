<?php
/**
 * Created by PhpStorm.
 * User: mert
 * Date: 11.09.16
 * Time: 0:09
 */

namespace mertvetsky\yii2SimpleContainerConfigurator;

use yii\base\Component;

/**
 * Class SimpleContainerConfig
 */
class SimpleContainerConfig extends Component
{
    /**
     * return [
     *  'smth' => [
     *      'class'        => \app\lib\smth\Smth::class,
     *      'singleton'    => false,
     *      'someParams'   => 'hello'
     *  ],
     *  'pew'  => [
     *      'class' => \app\lib\smth\Pewpew::class
     *  ]
     * ];
     */
    public $file;


    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->config();
    }


    private function config()
    {
        if (!is_file($this->file)) {
            throw new WrongConfigException($this->file . ' is not file');
        }
        $config = require $this->file;

        if (!is_array($config)) {
            throw new WrongConfigException('config is not array');
        }

        foreach ($config as $entry) {
            if (!is_array($entry)) {
                throw new WrongConfigException('config item is not array');
            }

            $params = $this->getParams($entry);

            if (!isset($entry['singleton']) || $entry['singleton'] == true) {
                \Yii::$container->setSingleton($entry['class'], $params);
            } else {
                \Yii::$container->set($entry['class'], $params);
            }
        }
    }


    private function getParams($entry)
    {
        $result = [];

        foreach ($entry as $key => $item) {
            if (!in_array($key, ['class', 'singleton'])) {
                $result[$key] = $item;
            }
        }

        return $result;
    }

}