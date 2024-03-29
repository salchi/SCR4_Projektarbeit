<?php self::renderView('partial/header', $model); ?>

<div class="container">
    <div class="row v-center">
        <div class="col-xs-10">
            <h1>Detail - <?php self::htmlOut($model['discussion']->getName()); ?></h1>
            <p>Created by <?php self::htmlOut($model['discussion']->getOriginator()); ?>, on <?php self::htmlOut($model['discussion']->getCreationDate()); ?></p>  
        </div>
        <div class="col-xs-2">
            <h4>
                <strong>
                    <?php
                    if ($model['currUser'] != null) {
                        self::actionLink('Add comment', 'Add', 'Comment', array(
                            'did' => $model['discussion']->getId(),
                            'red' => $model['redirectUrl']
                        ));
                    }
                    ?>
                </strong>
            </h4>
        </div>
    </div>
    <?php
    if (sizeof($model['discussion']->getComments()) > 0) {
        $numOfComments = sizeof($model['discussion']->getComments());
        self::renderView('partial/information', array('information' => "Disucssion has $numOfComments comment" . ($numOfComments > 1 ? 's' : '') . '.'));
    } else {
        self::renderView('partial/warning', array('warning' => 'Disucssion has no comments yet.'));
    }
    self::renderView('partial/commentsList', array(
        'currUser' => $model['currUser'],
        'redirectUrl' => self::getUrl('Detail', 'Discussion', array('id' => $model['discussion']->getId())),
        'comments' => $model['discussion']->getComments()
    ));
    ?>
</div>

<?php self::renderView('partial/confirmModal', array()); ?>

<script>
    $(function () {
        function scroll(hash) {
            $('html, body').animate({
                scrollTop: $(hash).offset().top - 60 + 'px'
            }, 1000, 'swing');
        }

        if (window.location.hash) {
            scroll(window.location.hash);
        }

        $(".comments-list a").on('click', function (e) {
            var href = $(this).attr('href');
            scroll(href.substr(href.indexOf("#")));
        });
    });
</script>

<?php self::renderView('partial/footer', $model); ?>