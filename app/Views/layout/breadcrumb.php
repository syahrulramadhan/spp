<style>
    .breadcrumb  .breadcrumb-item +  .breadcrumb-item::before { 
        content: ">"; 
    }
</style>

<nav aria-label="breadcrumb" class="pt-2" style="margin-bottom: -15px;">
    <ol class="breadcrumb">
        <li class="breadcrumb-item text-uppercase"><a href="<?= base_url(); ?>">Dashboard</a></li>
        <?php /* if($title):  */ ?>
        <li class="breadcrumb-item text-uppercase active" aria-current="page"><?php /* $title */ ?></li>
        <?php /* endif; */ ?>
    </ol>
</nav>