<?php self::renderView('partial/header', $model); ?>

<div class="container">
    <h1>Search</h1>

    <?php self::beginActionForm('FetchResult', 'Search', 'get'); ?>
    <div class="input-group">
        <input type="text" placeholder="search string" class="form-control" name="searchString" value="<?php self::htmlOut($model['searchString']); ?>" required>
        <div class="input-group-btn">
            <button class="btn btn-primary">Search</button>
        </div>
    </div>
    <br><br>
    <?php self::endActionForm(); ?>

    <?php
    if (sizeof($model['result']) > 0) {
        self::renderView('partial/information', array('information' => "Found " . $model['numberOfComments'] . " comment" . ($model['numberOfComments'] > 1 ? "s" : "")."."));
        self::renderView('partial/commentsList', array(
            'currUser' => $model['currUser'],
            'redirectUrl' => self::getUrl('Search', 'Search', array('searchString' => $model['searchString'])),
            'comments' => $model['result']
        ));
        self::renderView('partial/pagination', $model['paginationModel']);
    } else if ($model['result'] !== null) {
        self::renderView('partial/warning', array('warning' => "No comment contains '" . $model['searchString'] . "'."));
    }
    ?>
</div>

<?php self::renderView('partial/confirmModal', array()); ?>

<?php self::renderView('partial/footer', $model); ?>