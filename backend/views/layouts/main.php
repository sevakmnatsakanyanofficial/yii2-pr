<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['companyName'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => Yii::t('app', 'Home'), 'url' => ['/dashboard/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => mb_strtoupper (Yii::t('app', 'References')),
            'items' => [
                ['label' => Yii::t('app', 'Settings'), 'url' => ['/settings/index']],
            ]
        ];
        $menuItems[] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']];
        $menuItems[] = [
            'label' => mb_strtoupper (Yii::t('app', 'Data')),
            'items' => [
                ['label' => Yii::t('app', 'any'), 'url' => ['/any/index']],
                ['label' => Yii::t('app', 'any'), 'url' => ['/any/index']],
                ['label' => Yii::t('app', 'any'), 'url' => ['/any/index']],
            ]
        ];
        $menuItems[] = ['label' => Yii::t('app', 'Bookings'), 'url' => ['/booking/index']];
        $menuItems[] = ['label' => Yii::t('app', 'Logs'), 'url' => ['/log/index']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'activateParents' => true,
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

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->params['companyName'])?> LLC <?= date('Y') ?></p>

        <p class="pull-right">
        <?php
        echo Yii::t('app', 'Powered by {company}', [
            'company' => '<a href="http://" rel="external">' . Yii::t('app',
                    'some company') . '</a>',
        ]);
        ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
