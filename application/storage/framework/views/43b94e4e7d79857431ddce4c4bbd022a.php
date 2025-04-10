<div class="setup-welcome" id="setup-welcome">

    <!--image-->
    <div class="x-image">
        <img src="public/images/wizard.png">
    </div>

    <!--title-->
    <div class="x-title">
        <h2 class="text-info">Installation</h2>
    </div>

    <div class="x-subtitle">
        This wizard will guide you through the installation process. For help, please refer to our <a
            href="https://growcrm.io/documentation/">documentation</a>.
        </br>
    </div>

    <!--item-->











       
    <div class="x-button m-t-30">
        <button type="button" class="btn waves-effect waves-light btn-block btn-info js-ajax-request"
            data-button-loading-annimation="yes" data-button-disable-on-click="yes"
            data-type="form" 
            data-form-id="setup-welcome" 
            data-ajax-type="post"
            data-url="<?php echo e(url('setup/requirements')); ?>">Start Installation</button>
    </div>

</div><?php /**PATH C:\xampp\htdocs\application\resources\views/pages/setup/welcome.blade.php ENDPATH**/ ?>