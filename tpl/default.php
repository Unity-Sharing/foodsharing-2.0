<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $app->getTitle(); ?></title>

    <?= getHead(); ?>

</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#topbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Foodsharing v2.0</a>
            </div>
            <!-- /.navbar-header -->
		   <div class="collapse navbar-collapse" id="topbar">
           <?= getTemplate('topbar'); ?>
		   <?php //getTemplate('sidebar'); ?>
		   </div>
           
        </nav>

        <div id="page-wrapper">
            <?= getContent('main'); ?>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?= getFoot(); ?>

</body>

</html>