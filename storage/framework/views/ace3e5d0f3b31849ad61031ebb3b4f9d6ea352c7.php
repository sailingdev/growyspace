<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">


	<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

  
    <body class="bg-gray">
        <div class="row m-0 bg-gray" style="border:1px solid red;">
            <div class="col-md-8 mx-auto" style="border:1px solid blue;">
                <div class="card mt-5 mb-2 bgcolor-e1e3dd">
                    <div class="card-header pl-4 pr-4 color-opentowork h-100">
                        <div class="row m-0 p-0 opportunity_header">
                            <p class="w-65 m-0 p-0 font-weight-bold">Open-to-work</p>
                            <p class="w-35 m-0 p-0 text-right font-weight-bold ">
                            </p>
                            
                        </div>
                    </div>
                    <div class="card-block p-4">
                        <div class="row m-0 p-0 ">
                            <div class="w-100 profile_pitch ">
                                <h3 class="font-weight-bold ellipsis" onclick="toggleEllipsis(this)"><?php echo e($opc->title); ?></h3>
                                <p class="" onclick="toggleEllipsis(this)"><?php echo e($opc->email); ?></p>
                                <p class="" onclick="toggleEllipsis(this)"><?php echo e($opc->phone); ?></p>
                                
                                <p class="" onclick="toggleEllipsis(this)"><span class="fa fa-map-marker"></span> <span class="pl-2"><?php echo e($opc->city); ?>, <?php echo e(isset($countries[$opc->country_code]) ? $countries[$opc->country_code] : ''); ?> </span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html><?php /**PATH F:\XAMPP7.4\htdocs\growyspace 2.0\resources\views/PDF/opentowork.blade.php ENDPATH**/ ?>