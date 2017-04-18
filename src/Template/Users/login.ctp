<!-- File: src/Template/Users/login.ctp -->
<?=$this->assign('title', 'Login');?>
<div class="users form">
<?= $this->Flash->render('auth') ?>

<?= $this->Form->create(); ?>
    <div class="container">
        <div class="jumbotronHeader jumbotron">
            <div class="container">
                <div class="col-md-5"><?= $this->Html->image('logos/logo-tn.png', ['class' => 'logo-tn']); ?></div>
                <div class="col-md-2"><h2 class="nameApp"><?=APP_NAME?><sub class="versionApp"><?=APP_VERSION?></sub></h2></div>
                <!--div class="col-md-2"></?= $this->Html->image('logos/logo-palliserIntr.png', ['class' => 'logo-palliser']); ?></div-->
                <div class="col-md-5"><?= $this->Html->image('logos/logo-douane.png', ['class' => 'logo-douane pull-right']); ?></div>
            </div>
        </div>
    </div>
    <fieldset class="loginFieldset">
        <div class="titre-login"><?= $this->Html->image(COMPANY_LOGO, ['class' => 'logo-palliser']); ?></div>
        
        <div class="login">
        <h1><?= __('Please enter your username and password') ?></h1>
        <form method="post" action="index.html">
          <p><?= $this->Form->input('username', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false, 'placeholder' => 'Nom utilisateur']) ?></p>
          <p><?= $this->Form->input('password', ['templates' => ['inputContainer' => '{{content}}'], 'label' => false, 'placeholder' => 'Mot de passe']) ?></p>
          <p class="submit"><?= $this->Form->button(__('Login'), ['class' => 'btn btn-primary btn-block' ]); ?></p>
        </form>
      </div>
    </fieldset>
<?= $this->Form->end() ?>
</div>
