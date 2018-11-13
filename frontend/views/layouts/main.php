<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use lajax\languagepicker\widgets\LanguagePicker;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?= Html::beginTag('nav', [
        'class' => 'navbar navbar-default navbar-doublerow navbar-trans navbar-fixed-top',
    ])?>

    <?= Html::beginTag('nav', [
        'class' => 'navbar navbar-top hidden-xs',
    ])?>

    <?= Html::beginTag('div', [
        'class' => 'container',
    ])?>

    <?php
    $menuItems = [
        ['label' => '<i class="fa fa-facebook-square" aria-hidden="true"></i>', 'url' => 'https://facebook.com', 'linkOptions' => ['target' => '_blank']],
        ['label' => '<i class="fa fa-instagram" aria-hidden="true"></i>', 'url' => 'https://instagram.com', 'linkOptions' => ['target' => '_blank']],
        ['label' => '<i class="fa fa-linkedin-square" aria-hidden="true"></i>', 'url' => 'https://linkedin.com', 'linkOptions' => ['target' => '_blank']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-left'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]); ?>

    <?php
    $menuItems = [
        ['label' => 'What Is It', 'url' => '#', 'options' => ['class' => '', 'id' => 'btn-about', 'onclick' => 'return false;']],
        ['label' => 'Contact', 'url' => '#', 'options' => ['class' => '', 'id' => 'btn-contact-us', 'onclick' => 'return false;']],
        ['label' => 'How It Works', 'url' => '#', 'options' => ['class' => '', 'id' => 'btn-how-it-works', 'onclick' => 'return false;']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'nav navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]); ?>

    <?= Html::endTag('div')?>

    <?= Html::endTag('nav')?>

    <?php
    echo Html::beginTag('div', [
        'class' => 'hidden-xs dividline light-grey',
    ]);

    echo Html::endTag('div');

    NavBar::begin([
        'brandLabel' => Yii::$app->params['companyName'], //
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-down',
        ],
    ]);

    $menuItems = [
        ['label' => 'What Is It', 'url' => '#', 'options' => ['class' => 'visible-xs', 'id' => 'btn-about', 'onclick' => 'return false;']],
        ['label' => 'Contact', 'url' => '#', 'options' => ['class' => 'visible-xs', 'id' => 'btn-contact-us', 'onclick' => 'return false;']],
        ['label' => 'How It Works', 'url' => '#', 'options' => ['class' => 'visible-xs', 'id' => 'btn-how-it-works', 'onclick' => 'return false;']],

        ['label' => 'Become Partner', 'url' => '#', 'options' => ['class' => '']],
        [
            'label' => 'Download',
            'items' => [
                ['label' => 'Android', 'url' => '', 'options' => ['class' => '']],
                ['label' => 'IOS', 'url' => '', 'options' => ['class' => '']],
            ]
        ],
        ['label' => 'Help', 'url' => '#', 'options' => ['class' => '']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    ?>

    <div class="navbar-text pull-right hidden-xs">
        <?= LanguagePicker::widget([
            'itemTemplate' => '<li><a href="{link}" title="{language}"><i id="{language}"></i> {name}</a></li>',
            'activeItemTemplate' => '<a href="{link}" title="{language}"><i id="{language}"></i> {name}</a>',
            'parentTemplate' => '<div class="language-picker dropdown-list {size}"><div>{activeItem}<ul style="background-color: white">{items}</ul></div></div>',
            'languageAsset' => 'lajax\languagepicker\bundles\LanguageLargeIconsAsset',      // StyleSheets
            'languagePluginAsset' => 'lajax\languagepicker\bundles\LanguagePluginAsset',    // JavaScripts
        ]); ?>
    </div>

    <div class="navbar-text pull-right visible-xs">
        <?= LanguagePicker::widget([
            'skin' => LanguagePicker::SKIN_BUTTON,
            'size' => LanguagePicker::SIZE_SMALL
        ]);
        ?>
    </div>

    <?php
    NavBar::end();
    ?>

    <?= Html::endTag('nav')?>

    <div class="container-fluid">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer-nav">
    <div class="container">
        <div class="visible-xs visible-sm">
            <div class="row">
                <div class="col-xs-6">
                    <ul class="list-unstyled">
                        <li>WELCOME</li>
                        <li>Home</li>
                        <li>What Is It</li>
                        <li>Contact Us</li>
                        <li>How It Works</li>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <ul class="list-unstyled">
                        <li>WE ARE IN INTERNET</li>
                        <li>Facebook</li>
                        <li>Instagram</li>
                        <li>Linkedin</li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <ul class="list-unstyled">
                        <li>DOCUMENTATION</li>
                        <li><a href="<?php echo Url::to(['site/terms-conditions'])?>">Terms & Conditions</a></li>
                        <li><a href="<?php echo Url::to(['site/privacy-policy'])?>">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-xs-6">
                    <ul class="list-unstyled">
                        <li>Contact Us</li>
                        <li>Call Us</li>
                        <li>Write Us</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hidden-xs hidden-sm">
            <div class="row">
                <div class="col-md-3">
                    <ul class="list-unstyled">
                        <li>WELCOME</li>
                        <li>Home</li>
                        <li>What Is It</li>
                        <li>Contact Us</li>
                        <li>How It Works</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled">
                        <li>WE ARE IN INTERNET</li>
                        <li>Facebook</li>
                        <li>Instagram</li>
                        <li>Linkedin</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled">
                        <li>DOCUMENTATION</li>
                        <li><a href="<?php echo Url::to(['site/terms-conditions'])?>">Terms & Conditions</a></li>
                        <li><a href="<?php echo Url::to(['site/privacy-policy'])?>">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="list-unstyled">
                        <li>Contact Us</li>
                        <li>Call Us</li>
                        <li>Write Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->params['companyName'])?> LLC <?= date('Y') ?></p>

        <p class="pull-right">
            <?php
            echo Yii::t('app', 'Powered by {company}', [
                'company' => '<a href="" rel="external">' . Yii::t('app',
                        '') . '</a>',
            ]);
            ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
