# yii2-simple-container-configurator
Just add to config `components` block
```
        'containerConfig' => [
             'class' => \mertvetsky\yii2SimpleContainerConfigurator\SimpleContainerConfig::class,
             'file' => __DIR__ . '/services.php',
        ],
```

then create config/services.php file with your services definitions like
```
<?php

return [
    'smth' => [
        'class'     => \app\lib\smth\Smth::class,
        'singleton' => false,
        'message'   => 'from config'
    ],
    'pew'  => [
        'class' => \app\lib\smth\Pewpew::class
    ]
];
```

After that you can use your configured classes at any `\yii\base\Component` child class
```
    public function __construct($id, Module $module, Smth $smth, Pewpew $pewpew, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->smth = $smth;
        $this->pewpew = $pewpew;
    }
```